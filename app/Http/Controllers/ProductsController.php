<?php

namespace App\Http\Controllers;

use App\Http\Classes\dxResponse;
use App\Models\AttributeProductValues;
use App\Models\Attributes;
use App\Models\AttributesValues;
use App\Models\Category;
use App\Models\Department;
use App\Models\District;
use App\Models\dxDataGrid;
use App\Models\ExtraService;
use App\Models\Galerie;
use App\Models\Products;
use App\Models\Province;
use App\Models\Specifications;
use App\Models\SubCategory;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use SoDe\Extend\JSON;
use Illuminate\Support\Facades\Auth;
use SoDe\Extend\Fetch;
use SoDe\Extend\Response;
use SoDe\Extend\Text;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\isNull;

class ProductsController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $products =  Products::where("status", "=", true)->get();

    return view('pages.products.index', compact('products'));
  }

  public function reactView()
  {
    $products = Products::all();

    return Inertia::render('Admin/Products', [
      'products' => $products,
    ])->rootView('admin');
  }

  public function paginate(Request $request)
  {
    //validar el rol del usuario logueado 
    // $user = Auth::user();
    // dump($user->hasRole('Reseller'));

    $user = false;
    
    $response =  new dxResponse();
    try {
      $instance = Products::select([
        DB::raw('DISTINCT products.*')
      ])
        ->with(['category', 'tags'])
        ->leftJoin('attribute_product_values AS apv', 'products.id', 'apv.product_id')
        ->leftJoin('attributes AS a', 'apv.attribute_id', 'a.id')
        ->leftJoin('tags_xproducts AS txp', 'txp.producto_id', 'products.id')
        ->leftJoin('categories', 'categories.id', 'products.categoria_id') 
        ->where('categories.visible', 1) 
        ->where('categories.status', 1)   
        ->where('products.status', 1);
        
        if(Auth::check()){
          $user = Auth::user();
          $user = $user->hasRole('Reseller');
          if ($user) { // Cambia 'admin' por el rol que deseas validar
            $instance->where('products.precio_reseller', '>', 0);
         }
        }
        

      if ($request->group != null) {
        [$grouping] = $request->group;
        $selector = \str_replace('.', '__', $grouping['selector']);
        $instance = Products::select([
          "{$selector} AS key"
        ])
          ->groupBy($selector);
      }

      if ($request->filter) {
        $instance->where(function ($query) use ($request) {
          dxDataGrid::filter($query, $request->filter ?? [], false);
        });
      }

      if ($request->sort != null) {
        foreach ($request->sort as $sorting) {
          // $selector = \str_replace('.', '__', $sorting['selector']);
          $selector = $sorting['selector'];
          $instance->orderBy(
            $selector,
            $sorting['desc'] ? 'DESC' : 'ASC'
          );
        }
      } else {
        $instance->orderBy('products.id', 'DESC');
      }

      $totalCount = 0;
      if ($request->requireTotalCount) {
        $totalCount = $instance->count('*');
      }

      $jpas = [];
      if (!$request->ignoreData) {
        $jpas = $request->isLoadingAll
          ? $instance->get()
          : $instance
          ->skip($request->skip ?? 0)
          ->take($request->take ?? 10)
          ->get();
      }

      // $results = [];

      // foreach ($jpas as $jpa) {
      //   $result = JSON::unflatten($jpa->toArray(), '__');
      //   $results[] = $result;
      // }

      $response->status = 200;
      $response->message = 'Operación correcta';
      $response->data = $jpas;
      $response->totalCount = $totalCount;
      $response->is_proveedor = $user ; 
    } catch (\Throwable $th) {
      $response->status = 400;
      $response->message = $th->getMessage() . " " . $th->getFile() . ' Ln.' . $th->getLine();
    } finally {
      return response(
        $response->toArray(),
        $response->status
      );
    }
  }
  public function paginateOffers(Request $request)
  {
    $response =  new dxResponse();
    try {
      $instance = Products::select([
        DB::raw('DISTINCT products.*')
      ])
        ->with(['category', 'tags'])
        ->leftJoin('attribute_product_values AS apv', 'products.id', 'apv.product_id')
        ->leftJoin('attributes AS a', 'apv.attribute_id', 'a.id')
        ->leftJoin('tags_xproducts AS txp', 'txp.producto_id', 'products.id')
        ->where('descuento', '>', 0);

      if ($request->group != null) {
        [$grouping] = $request->group;
        $selector = \str_replace('.', '__', $grouping['selector']);
        $instance = Products::select([
          "{$selector} AS key"
        ])
          ->groupBy($selector);
      }

      if ($request->filter) {
        $instance->where(function ($query) use ($request) {
          dxDataGrid::filter($query, $request->filter ?? [], false);
        });
      }

      if ($request->sort != null) {
        foreach ($request->sort as $sorting) {
          // $selector = \str_replace('.', '__', $sorting['selector']);
          $selector = $sorting['selector'];
          $instance->orderBy(
            $selector,
            $sorting['desc'] ? 'DESC' : 'ASC'
          );
        }
      } else {
        $instance->orderBy('products.id', 'DESC');
      }

      $totalCount = 0;
      if ($request->requireTotalCount) {
        $totalCount = $instance->count('*');
      }

      $jpas = [];
      if (!$request->ignoreData) {
        $jpas = $request->isLoadingAll
          ? $instance->get()
          : $instance
          ->skip($request->skip ?? 0)
          ->take($request->take ?? 10)
          ->get();
      }

      // $results = [];

      // foreach ($jpas as $jpa) {
      //   $result = JSON::unflatten($jpa->toArray(), '__');
      //   $results[] = $result;
      // }

      $response->status = 200;
      $response->message = 'Operación correcta';
      $response->data = $jpas;
      $response->totalCount = $totalCount;
    } catch (\Throwable $th) {
      $response->status = 400;
      $response->message = $th->getMessage() . " " . $th->getFile() . ' Ln.' . $th->getLine();
    } finally {
      return response(
        $response->toArray(),
        $response->status
      );
    }
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $product = new Products();
    $atributos = Attributes::where("status", "=", true)->get();
    $valorAtributo = AttributesValues::where("status", "=", true)->get();
    $tags = Tag::where("status", "=", true)->get();
    $categoria = Category::all();
    $subcategories = SubCategory::all();
    $galery = [];
    $especificacion = [json_decode('{"tittle":"", "specifications":""}', false)];
    $servicios = [json_decode('{"service":"", "price":""}', false)];
    $distritos  = DB::select('select * from districts where active = ? order by 3', [1]);
    $provincias = DB::select('select * from provinces where active = ? order by 3', [1]);
    $departamentos = DB::select('select * from departments where active = ? order by 2', [1]);

    return view('pages.products.save', compact('servicios','product', 'atributos', 'valorAtributo', 'categoria', 'tags', 'especificacion', 'subcategories', 'galery', 'distritos', 'provincias', 'departamentos'));
  }

  public function synchronization(Request $request)
  {
      try {
          // Realizar solicitud GET a la API
          $response = Http::withHeaders([
              'Content-Type' => 'application/json',
              'X-API-Key' =>  env('PRICELABS_API_KEY')
          ])->get('https://api.pricelabs.co/v1/listings');

          // Decodificar la respuesta JSON
          $data = $response->json();
          // dd($data);
          // Verificar si la solicitud fue exitosa
          if (!$response->successful()) {
              throw new Exception($data['message'] ?? 'Ocurrió un error inesperado al recuperar los datos.');
          }

          // Recorrer los departamentos y sincronizar con la base de datos
          foreach ($data['listings'] as $departamento) {

                  // Buscar el departamento en la base de datos
                    $existingDept = Products::where('sku', $departamento['id'])->first();
                    
                    // Nueva ruta donde debería estar el archivo .ics
                    $calendarPath = public_path('storage/calendars/' . $departamento['id'] . '.ics');
                   

                    // Verificar si el archivo ya existe en la nueva ubicación
                    if (!File::exists($calendarPath)) {
                        // Crear la carpeta si no existe
                        if (!File::exists(public_path('calendars'))) {
                            File::makeDirectory(public_path('calendars'), 0755, true, true);
                        }

                        // Leer el calendario desde storage y guardarlo en public/calendars/
                        $oldCalendarPath = 'calendars/' . $departamento['id'] . '.ics'; // Asumiendo que están en storage/app/public/calendars/
                        
                        // if (Storage::exists($oldCalendarPath)) {
                        //     $calendarContent = Storage::get($oldCalendarPath);
                        //     file_put_contents($calendarPath, $calendarContent);
                        // } else {
                            // Si no existe en storage, generar un nuevo calendario
                            $calendar = Calendar::create($departamento['name'] . ' Calendar');
                            file_put_contents($calendarPath, $calendar->get());
                        // }
                    }

                    // Si el departamento existe, actualizar solo el campo calendar_url
                    if ($existingDept) {
                        $existingDept->update([
                            'calendar_url' => $calendarPath
                        ]);
                    }
                  // Verificar si el departamento ya existe en la base de datos
                  // $existingDept = Products::where('sku', $departamento['id'])->first();
                  
                  // if ($existingDept) {
                  //     // Actualizar el departamento existente
                  //     $existingDept->update([
                  //         'producto' => $departamento['name'],
                  //         'cuartos' => $departamento['no_of_bedrooms'],
                  //         'pms' => $departamento['pms'],
                  //         'preciobase' => $departamento['base'] ?? 0,
                  //         'preciomin' => $departamento['min']?? 0,
                  //     ]);
                  // } else {

                  //     $calendar = Calendar::create($departamento['name'] . ' Calendar');
                  //     $calendarPath = 'public/calendars/' . $departamento['id'] . '.ics';
                      
                  //     // Verificar y crear la carpeta si no existe
                  //     if (!File::exists(public_path('calendars'))) {
                  //       File::makeDirectory(public_path('calendars'), 0755, true, true);
                  //     }

                  //     // Crear el calendario
                  //     $calendar = Calendar::create($departamento['name'] . ' Calendar');
                  //     $calendarPath = public_path('calendars/' . $departamento['id'] . '.ics');

                  //     // Guardar el archivo en la carpeta public/calendars/
                  //     file_put_contents($calendarPath, $calendar->get());
                      
                  //     // Storage::put($calendarPath, $calendar->get());
                      
                  //     // Crear un nuevo departamento
                  //     Products::create([
                  //           'sku' => $departamento['id'],
                  //           'producto' => $departamento['name'],
                  //           'cuartos' => $departamento['no_of_bedrooms'],
                  //           'pms' => $departamento['pms'],
                  //           'preciobase' => $departamento['base'] ?? 0,
                  //           'preciomin' => $departamento['min'] ?? 0,
                  //           'categoria_id' => 1,
                  //           'calendar_url' => Storage::url($calendarPath)
                  //       ]);

                    
                  // } 
          }
          
          //return redirect()->route('products.index');
          return response()->json(['message' => 'Departamentos sincronizados exitosamente'], 200);
          
      } catch (Exception $e) {
          // Manejar errores
          return response()->json(['error' => $e->getMessage()], 500);
      }
  }


  


  public function edit(string $id)
  {

    $product =  Products::with('tags')->find($id);
    $atributos = Attributes::where("status", "=", true)->get();
    $valorAtributo = AttributesValues::where("status", "=", true)->get();
    $especificacion = Specifications::where("product_id", "=", $id)->get();
    if ($especificacion->count() == 0) $especificacion = [json_decode('{"tittle":"", "specifications":""}', false)];
    $servicios = ExtraService::where("product_id", "=", $id)->get();
    if ($servicios->count() == 0) $servicios = [json_decode('{"service":"", "price":""}', false)];
    $tags = Tag::where('status', 1)->get();
    $categoria = Category::all();
    $subcategories = SubCategory::all();
    $valoresdeatributo = AttributeProductValues::where("product_id", "=", $id)->get();
    $galery = Galerie::where("product_id", "=", $id)->get();

    $disabledDates = [];
    $startDate = null;
    $endDate = null;
    $icalUrl =  $product->airbnb_url;
    
    if ($icalUrl) {
      // Si hay un URL válido, obtenemos el contenido del archivo .ics
      $icalContent = file_get_contents($icalUrl);
     
      $lines = explode("\n", $icalContent);

    // Procesar las líneas del archivo .ics
      foreach ($lines as $line) {
          $line = trim($line); // Eliminar espacios en blanco

          // Buscar las líneas que contienen las fechas de inicio (DTSTART) y fin (DTEND)
          if (strpos($line, 'DTSTART') === 0) {
              // Extraer la fecha de inicio
              $startDate = Carbon::createFromFormat('Ymd', substr($line, strpos($line, ':') + 1))->startOfDay();
          } elseif (strpos($line, 'DTEND') === 0) {
              // Extraer la fecha de fin
              $endDate = Carbon::createFromFormat('Ymd', substr($line, strpos($line, ':') + 1))->startOfDay();
              $endDate->subDay(); // Restar un día porque el check-out ocurre en esta fecha
          }

          // Si tenemos las fechas de inicio y fin, generar las fechas entre ese rango
          if ($startDate && $endDate) {
              while ($startDate->lte($endDate)) {
                  $disabledDates[] = $startDate->format('Y-m-d');
                  $startDate->addDay();
              }

              // Reiniciar las variables para el siguiente evento
              $startDate = null;
              $endDate = null;
          }
      }
    } else {
      $disabledDates = [];
    }

    
    $departamentos = Department::where('active', '=', 1)->get();
    $provincias = Province::where('active', '=', 1)->where('department_id', $product->departamento_id)->get();
    $distritos  = District::where('active', '=', 1)->where('province_id', $product->provincia_id)->get();

    return view('pages.products.save', compact('disabledDates','servicios','product', 'atributos', 'valorAtributo', 'tags', 'categoria', 'especificacion', 'subcategories', 'galery', 'valoresdeatributo', 'departamentos', 'provincias', 'distritos'));
  }

  private function saveImg(Request $request, string $field)
  {
    try {
      //code...
      if (isset($request->id)) {
        $producto = Products::find($request->id);
        $ruta = $producto->$field;

        // dump($ruta);
        //borrar imagen
        if (!empty($ruta) && file_exists($ruta)) {
          // Borrar imagen
          unlink($ruta);
        }
      }
      if ($request->hasFile($field)) {
        $file = $request->file($field);
        $route = "storage/images/productos/{$request->categoria_id}/";
        // $route = "storage/images/productos/$request->categoria_id/";
        $nombreImagen = Str::random(10) . '_' . $field . '.' . $file->getClientOriginalExtension();
        // $nombreImagen = $request->sku.'.png';
        $manager = new ImageManager(new Driver());
        $img =  $manager->read($file);
        // $img->coverDown(340, 340, 'center');

        if (!file_exists($route)) {
          mkdir($route, 0777, true);
        }

        // $img->save($route . $nombreImagen);
        $img->save($route . $nombreImagen);
        return $route . $nombreImagen;
      }
      return null;
    } catch (\Throwable $th) {
      //throw $th;
      
    }
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    
    try {
      $especificaciones = [];
      $extraservice = [];
      $data = $request->all();
      
      $atributos = null;
      $tagsSeleccionados = $request->input('tags_id');
      // $valorprecio = $request->input('precio') - 0.1;

      $request->validate([
        'producto' => 'required',
        //'precio' => 'min:0|required|numeric',
        // 'descuento' => 'lt:' . $request->input('precio'),
      ]);

      // Imagenes
      $data['descuento'] = $data['descuento'] ?? 0;
      $data['preciolimpieza'] = $data['preciolimpieza'] ?? 0;
      $data['precioservicio'] = $data['precioservicio'] ?? 0;

     

      if ($request->hasFile('imagen')) {
        $data['imagen'] = $this->saveImg($request, 'imagen');
      }
      if ($request->hasFile('imagen_ambiente')) {
        $data['imagen_ambiente'] = $this->saveImg($request, 'imagen_ambiente');
      }
      if ($request->hasFile('image_texture')) {
        $data['image_texture'] = $this->saveImg($request, 'image_texture');
      }
      if ($request->hasFile('imagen_2')) {
        $data['imagen_2'] = $this->saveImg($request, 'imagen_2');
      }
      if ($request->hasFile('imagen_3')) {
        $data['imagen_3'] = $this->saveImg($request, 'imagen_3');
      }
      if ($request->hasFile('imagen_4')) {
        $data['imagen_4'] = $this->saveImg($request, 'imagen_4');
      }
      // $data['imagen_2'] = $this->saveImg($request, 'imagen_2');
      // $data['imagen_3'] = $this->saveImg($request, 'imagen_3');
      // $data['imagen_4'] = $this->saveImg($request, 'imagen_4');
        
      foreach ($data as $key => $value) {
        if (strstr($key, '-')) {
          //strpos primera ocurrencia que enuentre
          if (strpos($key, 'tittle-') === 0 || strpos($key, 'title-') === 0) {
            $num = substr($key, strrpos($key, '-') + 1); // Obtener el número de la especificación
            $especificaciones[$num]['tittle'] = $value; // Agregar el título al array asociativo
          } elseif (strpos($key, 'specifications-') === 0) {
            $num = substr($key, strrpos($key, '-') + 1); // Obtener el número de la especificación
            $especificaciones[$num]['specifications'] = $value; // Agregar las especificaciones al array asociativo
          }
        }
      }

      foreach ($data as $key => $value) {
        if (strstr($key, '-')) {
          //strpos primera ocurrencia que enuentre
          if (strpos($key, 'service-') === 0) {
            $num = substr($key, strrpos($key, '-') + 1); // Obtener el número de la especificación
            $extraservice[$num]['service'] = $value; // Agregar el título al array asociativo
          } elseif (strpos($key, 'price-') === 0) {
            $num = substr($key, strrpos($key, '-') + 1); // Obtener el número de la especificación
            $extraservice[$num]['price'] = $value; // Agregar las especificaciones al array asociativo
          }
        }
      }

      if (array_key_exists('destacar', $data)) {
        if (strtolower($data['destacar']) == 'on') $data['destacar'] = 1;
      }
      if (array_key_exists('recomendar', $data)) {
        if (strtolower($data['recomendar']) == 'on') $data['recomendar'] = 1;
      }

      
      if (array_key_exists('mascota', $data)) {
        if (strtolower($data['mascota']) == 'on') $data['mascota'] = 1;
      }else{
        $data['mascota'] = 0;
      }

      if (array_key_exists('mobiliado', $data)) {
        if (strtolower($data['mobiliado']) == 'on') $data['mobiliado'] = 1;
      }else{
        $data['mobiliado'] = 0;
      }
    
      $cleanedData = Arr::where($data, function ($value, $key) {
        return !is_null($value);
      });

      if (!isset($cleanedData['stock'])) {
         $cleanedData['stock'] = 0 ;
      }

       $cleanedData['description'] = $data['description'];
      // $cleanedData['order'] = $data['order'];
       $cleanedData['extract'] = $data['extract'];
      // $cleanedData['especificacion'] = $data['especificacion'];
       $cleanedData['cuartos'] = $data['cuartos'];
       $cleanedData['banios'] = $data['banios'];
       $cleanedData['area'] = $data['area'];
       $cleanedData['pisos'] = $data['pisos'];
       $cleanedData['cochera'] = $data['cochera'];
       $cleanedData['movilidad'] = $data['movilidad'];
       $cleanedData['incluye'] = $data['incluye'];
       $cleanedData['no_incluye'] = $data['no_incluye'];
       $cleanedData['disponible'] = $data['disponible'];
       $cleanedData['no_disponible'] = $data['no_disponible'];
       $cleanedData['meta_title'] = $data['meta_title'];
       $cleanedData['meta_description'] = $data['meta_description'];
       $cleanedData['meta_keywords'] = $data['meta_keywords'];

      $slug = strtolower(str_replace(' ', '-', $request->producto . '-' . $request->color));

      if (Category::where('slug', $slug)->exists()) {
        $slug .= '-' . rand(1, 1000);
      }

      // Busca el producto, si existe lo actualiza, si no lo crea
      $producto = Products::find($request->id);
      if ($producto) {
        $cleanedData['max_stock'] = $this->gestionarMaxStock($producto->max_stock, $cleanedData['stock']);
        $producto->update($cleanedData);
      } else {
        $cleanedData['max_stock'] = $cleanedData['stock'];
        $producto = Products::create($cleanedData);
      }

      AttributeProductValues::where('product_id', $producto->id)->delete();

      if (isset($data['attributes']) && is_array($data['attributes'])) {
        foreach ($data['attributes'] as $attribute_id => $value_id) {
          if (is_array($value_id)) {
            foreach ($value_id as $id) {
              AttributeProductValues::create([
                'product_id' => $producto->id,
                'attribute_id' => $attribute_id,
                'attribute_value_id' => $id
              ]);
            }
          } else {
            AttributeProductValues::create([
              'product_id' => $producto->id,
              'attribute_id' => $attribute_id,
              'attribute_value_id' => $value_id
            ]);
          }
        }
      }

      $this->GuardarEspecificaciones($producto->id, $especificaciones);
      $this->GuardarExtraService($producto->id, $extraservice);
      $producto->tags()->sync($tagsSeleccionados);

      Galerie::where('product_id', $producto->id)->delete();
      if ($request->galery) {
        foreach ($request->galery as $value) {
          [$id, $name] = explode('|', $value);
          Galerie::updateOrCreate([
            'product_id' => $id,
            'id' => $id
          ], [
            'imagen' => $name,
            'product_id' => $producto->id
          ]);
        }
      }

      return redirect()->route('products.index')->with('success', 'Publicación creado exitosamente.');
    } catch (\Throwable $th) {
      //  dump($th->getMessage());
      
    }
  }

  private function TagsXProducts($id, $nTags)
  {
    DB::delete('delete from tags_xproducts where producto_id = ?', [$id]);
    foreach ($nTags as $key => $value) {
      DB::insert('insert into tags_xproducts (producto_id, tag_id) values (?, ?)', [$id, $value]);
    }
  }

  private function gestionarMaxStock($stock_actual, $nuevo_stock)
  {
    if ($nuevo_stock > $stock_actual) {
      return $nuevo_stock;
    }
    return $stock_actual;
  }


  private function GuardarEspecificaciones($id, $especificaciones)
  {
    Specifications::where('product_id', $id)->delete();
    foreach ($especificaciones as $value) {
      if (!$value['tittle'] || !$value['specifications']) continue;
      $value['product_id'] = $id;
      Specifications::create($value);
    }
  }

  private function GuardarExtraService($id, $especificaciones)
  {
    ExtraService::where('product_id', $id)->delete();
    foreach ($especificaciones as $value) {
      if (!$value['service'] || !$value['price']) continue;
      $value['product_id'] = $id;
      ExtraService::create($value);
    }
  }

  private function actualizarEspecificacion($especificaciones)
  {
    foreach ($especificaciones as $key => $value) {
      $espect = Specifications::find($key);
      $espect->tittle = $value['tittle'];
      $espect->specifications = $value['specifications'];

      if ($value['specifications'] == null) {
        $espect->delete();
      } else {
        $espect->save();
      }
    }
  }

  private function stringToObject($key, $atributos)
  {

    $parts = explode(':', $key);
    $nombre = strtolower($parts[0]); // Nombre del atributo
    $valor = strtolower($parts[1]); // Valor del atributo en minúsculas

    // Verifica si el atributo ya existe en el array
    if (isset($atributos[$nombre])) {
      // Si el atributo ya existe, agrega el nuevo valor a su lista
      $atributos[$nombre][] = $valor;
    } else {
      // Si el atributo no existe, crea una nueva lista con el valor
      $atributos[$nombre] = [$valor];
    }
    return $atributos;
  }

  /**
   * Display the specified resource.
   */
  public function show(Products $products)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  // public function update(Request $request, string $id)
  // {
  //   $especificaciones = [];
  //   $product = Products::find($id);
  //   $tagsSeleccionados = $request->input('tags_id');
  //   $data = $request->all();
  //   $atributos = null;







  //   $request->validate([
  //     'producto' => 'required',
  //   ]);

  //   if ($request->hasFile("imagen")) {
  //     $file = $request->file('imagen');
  //     $routeImg = 'storage/images/imagen/';
  //     $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();

  //     $this->saveImg($file, $routeImg, $nombreImagen);

  //     $data['imagen'] = $routeImg . $nombreImagen;
  //     // $AboutUs->name_image = $nombreImagen;
  //   }

  //   if ($request->hasFile("imagen_ambiente")) {
  //     $file = $request->file('imagen_ambiente');
  //     $routeImg = 'storage/images/imagen_ambiente/';
  //     $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();

  //     $this->saveImg($file, $routeImg, $nombreImagen);

  //     $data['imagen_ambiente'] = $routeImg . $nombreImagen;
  //     // $AboutUs->name_image = $nombreImagen;
  //   }

  //   foreach ($request->all() as $key => $value) {

  //     if (strstr($key, ':')) {
  //       // Separa el nombre del atributo y su valor
  //       $atributos = $this->stringToObject($key, $atributos);
  //       unset($request[$key]);
  //     } elseif (strstr($key, '-')) {
  //       //strpos primera ocurrencia que enuentre
  //       if (strpos($key, 'tittle-') === 0 || strpos($key, 'title-') === 0) {
  //         $num = substr($key, strrpos($key, '-') + 1); // Obtener el número de la especificación
  //         $especificaciones[$num]['tittle'] = $value; // Agregar el título al array asociativo
  //       } elseif (strpos($key, 'specifications-') === 0) {

  //         $num = substr($key, strrpos($key, '-') + 1); // Obtener el número de la especificación
  //         $especificaciones[$num]['specifications'] = $value; // Agregar las especificaciones al array asociativo
  //       }
  //     }
  //   }








  //   $jsonAtributos = json_encode($atributos);

  //   if (array_key_exists('destacar', $data)) {
  //     if (strtolower($data['destacar']) == 'on') $data['destacar'] = 1;
  //   }
  //   if (array_key_exists('recomendar', $data)) {
  //     if (strtolower($data['recomendar']) == 'on') $data['recomendar'] = 1;
  //   }



  //   $data['atributes'] = $jsonAtributos;
  //   $cleanedData = Arr::where($data, function ($value, $key) {
  //     return !is_null($value);
  //   });
  //   $product->update($cleanedData);

  //   DB::delete('delete from attribute_product_values where product_id = ?', [$product->id]);

  //   if (isset($atributos)) {
  //     foreach ($atributos as $atributo => $valores) {
  //       $idAtributo = Attributes::where('titulo', $atributo)->first();

  //       foreach ($valores as $valor) {
  //         $idValorAtributo = AttributesValues::where('valor', $valor)->first();

  //         if ($idAtributo && $idValorAtributo) {
  //           DB::table('attribute_product_values')->insert([
  //             'product_id' => $product->id,
  //             'attribute_id' => $idAtributo->id,
  //             'attribute_value_id' => $idValorAtributo->id,
  //           ]);
  //         }
  //       }
  //     }
  //   }

  //   DB::delete('delete from tags_xproducts where producto_id = ?', [$id]);
  //   if (!is_null($tagsSeleccionados)) {
  //     $this->TagsXProducts($id, $tagsSeleccionados);
  //   }
  //   $this->actualizarEspecificacion($especificaciones);
  //   return redirect()->route('products.index')->with('success', 'Producto editado exitosamente.');
  // }

  /**
   * Remove the specified resource from storage.
   */
  public function borrar(Request $request)
  {
    //softdelete
    $product = Products::find($request->id);
    $product->status = 0;
    $product->save();
  }

  public function updateVisible(Request $request)
  {
    $id = $request->id;
    $field = $request->field;
    $status = $request->status;

    // Verificar si el producto existe
    $product = Products::find($id);

    if (!$product) {
      return response()->json(['message' => 'Producto no encontrado'], 404);
    }

    // Actualizar el campo dinámicamente
    $product->update([
      $field => $status
    ]);
    return response()->json(['message' => 'registro actualizado']);
  }

  public function getProvincias($id)
  {
      $provincias = DB::table('provinces')->where('department_id', $id)->get();
      return response()->json($provincias);
  }

  public function getDistritos($id)
  {
      $distritos = DB::table('districts')->where('province_id', $id)->get();
      return response()->json($distritos);
  }
}
