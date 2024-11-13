<?php

namespace App\Http\Controllers;

use App\Models\ClientLogos;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\FlareClient\Http\Client;

class LogosClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logos = ClientLogos::where("status", "=", true)
        ->orderBy('order', 'asc')
        ->get();
        return view('pages.logos.index', compact('logos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
       
        return view('pages.logos.create');
    }


    public function saveImg($file, $route, $nombreImagen){
		$manager = new ImageManager(new Driver());
		$img =  $manager->read($file);

		if (!file_exists($route)) {
			mkdir($route, 0777, true); // Se crea la ruta con permisos de lectura, escritura y ejecución
	}

		$img->save($route . $nombreImagen);
	}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
        ]);

        $logo = new ClientLogos();


        if($request->hasFile("imagen")){
            $nombreImagen = Str::random(10) . '_' . $request->file('imagen')->getClientOriginalName(); 
            $file =  $request->file('imagen');
            $route = 'storage/images/logos/';
            $this->saveImg($file, $route, $nombreImagen);
            $logo->url_image =  $route.$nombreImagen; 
        }


        if($request->hasFile("imagen2")){
           
            $nombreImagen2 = Str::random(10) . '_' . $request->file('imagen2')->getClientOriginalName();   
            $file2 =  $request->file('imagen2');
            $route2 = 'storage/images/logos/';
            $this->saveImg($file2, $route2, $nombreImagen2);
            $logo->url_image2 =  $route2.$nombreImagen2; 
        }

        $logo->title = $request->title;
        $logo->description = $request->description;
        $logo->order = $request->order;
        $logo->status = 1;
        $logo->save();
        return redirect()->route('logos.index')->with('success', 'Publicación creado exitosamente.');
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
        $logo = ClientLogos::find($id);
        return view('pages.logos.edit', compact('logo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'=>'required',
        ]);

        $logo = ClientLogos::find($id);
        
        try {
			if($request->hasFile("imagen")){

                $nombreImagen = Str::random(10) . '_' . $request->file('imagen')->getClientOriginalName(); 
                $file =  $request->file('imagen');
                $route = 'storage/images/logos/';
               
                $this->saveImg($file, $route, $nombreImagen);
    
                $logo->url_image =  $route.$nombreImagen; 
            }
    
    
            if($request->hasFile("imagen2")){
               
                $nombreImagen2 = Str::random(10) . '_' . $request->file('imagen2')->getClientOriginalName();   
                $file2 =  $request->file('imagen2');
                $route2 = 'storage/images/logos/';
                
                $this->saveImg($file2, $route2, $nombreImagen2);
               
                $logo->url_image2 =  $route2.$nombreImagen2; 
            }
	
			$logo->title = $request->title;
            $logo->order = $request->order;
            $logo->description = $request->description;
			$logo->save();

			return redirect()->route('logos.index')->with('success', 'Publicación creado exitosamente.');


		} catch (\Throwable $th) {
			return response()->json(['messge' => 'Verifique sus datos '], 400); 
		}

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       

        
    }

    function deleteLogo(Request $request) {

        $logo = ClientLogos::findOrfail($request->id); 
        
        
    
        // Eliminar la imagen si existe
        if ($logo->url_image && file_exists($logo->url_image)) {
            unlink($logo->url_image);
        }

        // Eliminar el logo de la base de datos
        $logo->delete();
        return response()->json(['message'=>'Logo eliminado']);
    }



    public function updateVisible(Request $request)
    {
        // Lógica para manejar la solicitud AJAX
        $cantidad = $this->contarCategoriasDestacadas();


        if ($cantidad >= 100000 && $request->status == 1) {
            return response()->json(['message' => 'Solo puedes destacar 10000 categorias'], 409);
        }


        $id = $request->id;

        $field = $request->field;

        $status = $request->status;

        $category = ClientLogos::findOrFail($id);

        $category->$field = $status;

        $category->save();

        $cantidad = $this->contarCategoriasDestacadas();


        return response()->json(['message' => 'Marca modificada',  'cantidad' => $cantidad]);
    }


    public function contarCategoriasDestacadas()
    {

        $cantidad = ClientLogos::where('destacar', '=', 1)->count();

        return  $cantidad;
    }
}
