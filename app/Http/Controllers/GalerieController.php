<?php

namespace App\Http\Controllers;

use App\Models\Galerie;
use App\Models\Products;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use SoDe\Extend\Crypto;
use SoDe\Extend\Response;

class GalerieController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$galerie = Galerie::where("status", "=", true)->get();
		return view('pages.galerie.index', compact('galerie'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$productos = Products::all();
		return view('pages.galerie.create', compact('productos'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{

		$data = $request->all();


		try {
			$request->validate([
				'product_id' => 'required',
			]);

			foreach ($data as $key => $value) {


				// Comprueba si la clave comienza con 'imagen'
				if (strpos($key, 'imagen') === 0) {

					if ($request->hasFile($key)) {
						$file = $request->file($key);
						$routeImg = 'storage/images/imagen/';
						// $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();
						$nombreImagen = Str::random(10) . '_' . $file . '.webp';
						$this->saveImg($file, $routeImg, $nombreImagen);

						$data['imagen'] = $routeImg . $nombreImagen;
						$producto = Galerie::create($data);
						// $AboutUs->name_image = $nombreImagen;
					}
				}
			}

			return redirect()->route('galerie.index')->with('success', 'Publicación creado exitosamente.');
		} catch (\Throwable $th) {
			return $th;
		}
	}

	public function saveImage(Request $request)
	{
		$response = new Response();
		try {
			if (!$request->hasFile('image')) throw new Exception("Seleccione una imagen valida");
			$file = $request->file('image');
			$route = 'storage/images/galery/';
			$nombreImagen = Crypto::randomUUID() . '.' . $file->getClientOriginalExtension();
			$manager = new ImageManager(new Driver());
			$img =  $manager->read($file);
			$encoded = $img->toWebp(75);
			

			if (!file_exists($route)) {
				mkdir($route, 0777, true);
			}

			
			$encoded->save($route . $nombreImagen);
			$fileSize = filesize($route . $nombreImagen);
        	$maxSize = 1000000;

			if ($fileSize > $maxSize) {
				$encoded = $img->toWebp(60);
				$encoded->save($route . $nombreImagen);
			  }

			$response->status = 200;
			$response->message = 'Operacion correcta';
			$response->data = [
				'name' => $route . $nombreImagen
			];
		} catch (\Throwable $th) {
			$response->status = 400;
			$response->message = $th->getMessage();
		} finally {
			return response($response->toArray(), $response->status);
		}
	}

	public function saveImg($file, $route, $nombreImagen)
	{
		$manager = new ImageManager(new Driver());
		$img =  $manager->read($file);

		$maxSize = 1800000; 
		$originalFileSize = filesize($file);
		$initialQuality = ($originalFileSize > $maxSize) ? 60 : 80;
		$encoded = $img->toWebp($initialQuality);

		if (!file_exists($route)) {
			mkdir($route, 0777, true); // Se crea la ruta con permisos de lectura, escritura y ejecución
		}

		$encoded->save($route . $nombreImagen);
		$fileSize = filesize($route . $nombreImagen);
		$maxSize = 1000000;

		if ($fileSize > $maxSize) {
			$encoded = $img->toWebp(80);
			$encoded->save($route . $nombreImagen);
		}
}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id)
	{

		$galerie = Products::find($id);

		$productsWithGalleries = Products::with('galeria')->get();

		return view('pages.galerie.edit', compact('productsWithGalleries'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id)
	{

		$datos = $request->all();
		$datos['product_id'] = $id;

		try {

			$galerie = Galerie::where("product_id", "=", $id)->update([
				'valor' => $datos['valor'],
				'descripcion' => $datos['descripcion'],
				'color' => $datos['color']

			]);

			if ($galerie < 5) {
				$insertar = 5 - $galerie;
				$i = 0;
				foreach ($datos as $key => $valor) {
					if ($i < $insertar) {
						if (strpos($key, 'imagen') === 0) {
							if ($request->hasFile($key)) {
								$file = $request->file($key);
								$routeImg = 'storage/images/imagen/';
								//$nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();
								$nombreImagen = Str::random(10) . '_' . $file . '.webp';
								$this->saveImg($file, $routeImg, $nombreImagen);

								$datos['imagen'] = $routeImg . $nombreImagen;
								$producto = Galerie::create($datos);
								// $AboutUs->name_image = $nombreImagen;
								$i++;
							}
						}
					}
				}
			}
			return redirect()->route('galerie.index')->with('success', 'Publicación creado exitosamente.');
		} catch (\Throwable $th) {
		}
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{
		//
	}
	public function borrar(Request $request)
	{


		try {
			$product = Galerie::find($request->id);
			if ($product->imagen && file_exists($product->imagen)) {
				unlink($product->imagen);
			}


			$product->delete();
		} catch (\Throwable $th) {
		}
	}

	public function updateVisible(Request $request)
	{
		try {
			$id = $request->id;

			$status = $request->status;

			$testimony = Galerie::findOrFail($id);

			$testimony->visible = $status;

			$testimony->save();

			return response()->json(['message' => 'Estado modificado.']);
		} catch (\Throwable $th) {
			return response()->json(['message' => $th], 400);
		}
	}
}
