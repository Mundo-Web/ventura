<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use App\Helpers\EmailConfig;
use App\Http\Requests\StoreIndexRequest;
use App\Http\Requests\UpdateIndexRequest;
use App\Models\AboutUs;
use App\Models\Address;
use App\Models\AttributeProductValues;
use App\Models\Attributes;
use App\Models\AttributesValues;
use App\Models\Banners;
use App\Models\Blog;
use App\Models\Faqs;
use App\Models\General;
use App\Models\Index;
use App\Models\Message;
use App\Models\Products;
use App\Models\Slider;
use App\Models\Strength;
use App\Models\Testimony;
use App\Models\Category;
use App\Models\ClientLogos;
use App\Models\Department;
use App\Models\District;
use App\Models\ExtraService;
use App\Models\Galerie;
use App\Models\HomeView;
use App\Models\NosotrosView;
use App\Models\Offer;
use App\Models\PolyticsCondition;
use App\Models\Popup;
use App\Models\Price;
use App\Models\Province;
use App\Models\Sale;
use App\Models\Specifications;
use App\Models\Status;
use App\Models\Tag;
use App\Models\TermsAndCondition;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\Wishlist;
use Attribute;
use Carbon\Carbon;
use Culqi\Culqi;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use phpseclib3\File\ASN1\Maps\AttributeValue;
use SoDe\Extend\Response;
use Exception;
use Kigkonsult\Icalcreator\Ical;
use SoDe\Extend\Fetch;

use function PHPUnit\Framework\isNull;

class IndexController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    // $productos = Products::all();
    $url_env = env('APP_URL');
    $productos =  Products::with('tags')->get();
    $ultimosProductos = Products::select('products.*')->join('categories', 'products.categoria_id', '=', 'categories.id')->where('categories.visible', 1)->where('categories.status', 1)->where('products.status', '=', 1)->where('products.visible', '=', 1)->where('products.destacar', '=', 1)->orderBy('products.id', 'desc')->get();
    $productosPupulares = Products::select('products.*')
          ->join('categories', 'products.categoria_id', '=', 'categories.id')
          ->where('categories.visible', 1)
          ->where('products.status', '=', 1)
          ->where('products.visible', '=', 1)
          ->where('products.destacar', '=', 1)
          ->orderBy('products.id', 'desc')
          ->take(8)
          ->get();
    $blogs = Blog::where('status', '=', 1)->where('visible', '=', 1)->orderBy('id', 'desc')->take(3)->get();
    $banners = Banners::where('status',  1)->where('visible',  1)->get()->toArray();

    $categorias = Category::where('destacar', '=', 1)->where('visible', '=', 1)->get();
    $categoriasAll = Category::where('visible', '=', 1)->get();
    $destacados = Products::where('products.destacar', '=', 1)->where('products.status', '=', 1)
      ->where('visible', '=', 1)->with('tags')->activeDestacado()->get();
    $descuentos = Products::where('products.descuento', '>', 0)->where('products.status', '=', 1)
      ->where('visible', '=', 1)->with('tags')->activeDestacado()->get();

    $popups = Popup::where('status', '=', 1)->where('visible', '=', 1)->get();

   
    $benefit = Strength::where('status', '=', 1)->get();
    $faqs = Faqs::where('status', '=', 1)->where('visible', '=', 1)->get();
    $testimonie = Testimony::where('status', '=', 1)->where('visible', '=', 1)->get();
    $slider = Slider::where('status', '=', 1)->where('visible', '=', 1)->get();
    $category = Category::where('status', '=', 1)->where('destacar', '=', 1)->get();
    $general = General::first();
    $textoshome = HomeView::first();
    $estadisticas = ClientLogos::where('status', '=', 1)->where('visible', '=', 1)->get();
    $categoriasindex = Category::where('status', '=', 1)->where('destacar', '=', 1)->get();
    $distritosParaFiltro = Products::where('status', 1)
    ->where('visible', 1)
    ->with('distrito')
    ->get()
    ->groupBy('distrito_id');
    $distritosfiltro = Products::where('status', '=', 1)->where('visible', '=', 1)->get();
    $limitepersonas = $distritosfiltro->pluck('precioservicio')->filter(function ($precio) {
      return $precio > 0; // Excluir valores no válidos
    });
    $limite = $limitepersonas->max();
  return view('public.index', compact('distritosParaFiltro','limite','distritosfiltro','textoshome','general','url_env', 'popups', 'banners', 'blogs', 'categoriasAll', 'productosPupulares', 'ultimosProductos', 'productos', 'destacados', 'descuentos', 'general', 'benefit', 'faqs', 'testimonie', 'slider', 'categorias', 'categoriasindex','estadisticas'));
  }

  public function catalogo(Request $request, string $id_cat = null)
  {
    $tag_id = null;
    $tag_id = $request->input('tag');

    $catId = $request->input('category');
    $subCatId = $request->input('subcategoria');
    $tag_id = $request->input('tag');
    $id_cat = $id_cat ?? $catId;

    $lugar = $request->input('lugar') ?? '';
    $cantidad = $request->input('cantidad_personas') ?? '';
    $llegada = $request->input('fecha_llegada') ?? '';
    $salida = $request->input('fecha_salida') ?? '';
    $client = new Client();
    $consultaapi = Products::where('status', 1)->where('visible', 1)->get();

    $query = Products::where('status', 1)
    ->where('visible', 1)
    ->with('distrito');

    // Verifica si se proporcionó el lugar y la cantidad
    if (!empty($lugar)) {
        $query->where('distrito_id', $lugar);
    }

    if (!empty($cantidad)) {
        $query->where('precioservicio', '>=', $cantidad);
    }

    if (!empty($llegada) && !empty($salida)) {
      
      $checkin = Carbon::createFromFormat('d/m/Y', $request->input('fecha_llegada'))->format('Y-m-d');
      $checkout = Carbon::createFromFormat('d/m/Y', $request->input('fecha_salida'))->format('Y-m-d');
      
       $listings = [];

        foreach ($consultaapi as $department) {
            $listings[] = [
                'id' => $department->sku, 
                'pms' => $department->pms, 
                'dateFrom' => $checkin,
                'dateTo' => $checkout,
                "reason" => false
            ];
        }

      try {
            $response = $client->post('https://api.pricelabs.co/v1/listing_prices', [
                'headers' => [
                    'X-API-Key' => env('PRICELABS_API_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'json' => ['listings' => $listings]
            ]);

            $data = json_decode($response->getBody(), true);
            
            $availableDepartments = [];

            foreach ($data as $department) {
                // Si la respuesta contiene un error, ignorarlo
                if (isset($department['error'])) {
                    continue;
                }
    
                $allAvailable = true; // Variable para verificar si todas las fechas están disponibles
                foreach ($department['data'] as $availability) {
                    // Verificar si alguna de las fechas tiene el estado "Booked"
                    if (strpos($availability['booking_status'], 'Booked') !== false) {
                        $allAvailable = false; // Si alguna fecha está reservada, marcamos como no disponible
                        break; // Salir del loop si encontramos una fecha "Booked"
                    }
                }
    
                // Si todas las fechas están disponibles, añadir el departamento a la lista
                if ($allAvailable) {
                    $availableDepartments[] = $department['id'];
                }
            }

           
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Solicitud fallida',
                'desc' => $e->getMessage(),
            ], 400);
        }

        $query->whereIn('sku', $availableDepartments);
    }



    // Ordena por ID descendente y obtén los resultados
    $products = $query->orderBy('id', 'desc')->get();


    // $categories = Category::with('subcategories')->where('visible', true)->get();
    $categories = Category::with(['subcategories' => function ($query) {
      $query->whereHas('products');
    }])->where('visible', true)->get();

    $tags = Tag::where('visible', true)->get();

    $minPrice = Products::select()
      ->where('visible', true)
      ->where('descuento', '>', 0)
      ->min('descuento');
    if ($minPrice) Products::where('visible', true)->min('precio');
    $maxPrice = Products::max('precio');

    $attribute_values = AttributesValues::select('attributes_values.*')
      ->with('attribute')
      ->join('attributes', 'attributes.id', '=', 'attributes_values.attribute_id')
      ->where('attributes_values.visible', true)
      ->where('attributes.visible', true)
      ->get();

    $textoshome = HomeView::first();
    $distritosParaFiltro = Products::where('status', 1)
    ->where('visible', 1)
    ->with('distrito')
    ->get()
    ->groupBy('distrito_id');
    $distritosfiltro = Products::where('status', '=', 1)->where('visible', '=', 1)->with('distrito')->get();
    $limitepersonas = $distritosfiltro->pluck('precioservicio')->filter(function ($precio) {
      return $precio > 0; // Excluir valores no válidos
    });
    $limite = $limitepersonas->max() ?? 1;



    return view('public.catalogo' , compact('distritosParaFiltro', 'lugar','cantidad','llegada','salida','products','minPrice','maxPrice','categories','tags','attribute_values','id_cat','tag_id','textoshome','distritosfiltro','limite'));
    // return Inertia::render('Catalogo', [
    //   'component' => 'Catalogo',
    //   'minPrice' => $minPrice,
    //   'maxPrice' => $maxPrice,
    //   'categories' => $categories,
    //   'tags' => $tags,
    //   'attribute_values' => $attribute_values,
    //   'id_cat' => $id_cat,
    //   'tag_id' => $tag_id,
    //   'textoshome' => $textoshome,
    //   'subCatId' => $subCatId,
    //   'distritosfiltro' => $distritosfiltro,
    //   'limite' => $limite

    // ])->rootView('app');
  }

  public function obtenerDepartamentos(Request $request){
      
      $lugar = $request->input('lugar') ?? '';
      $cantidad = $request->input('cantidad_personas') ?? '';
      $llegada = $request->input('llegada') ?? '';
      $salida = $request->input('salida') ?? '';
      $client = new Client();

      $consultaapi = Products::where('status', 1)->where('visible', 1)->get();

      $query = Products::where('status', 1)
      ->where('visible', 1)
      ->with('distrito');

      // Verifica si se proporcionó el lugar y la cantidad
      if (!empty($lugar)) {
          $query->where('distrito_id', $lugar);
      }

      if (!empty($cantidad)) {
          $query->where('precioservicio', '>=', $cantidad);
      }
    
      if (!empty($llegada) && !empty($salida)) {

        $checkin = Carbon::createFromFormat('d/m/Y', $request->input('llegada'))->format('Y-m-d');
        $checkout = Carbon::createFromFormat('d/m/Y', $request->input('salida'))->format('Y-m-d');
       
        $listings = [];

          foreach ($consultaapi as $department) {
              $listings[] = [
                  'id' => $department->sku, 
                  'pms' => $department->pms, 
                  'dateFrom' => $checkin,
                  'dateTo' => $checkout,
                  "reason" => false
              ];
          }

        try {
              $response = $client->post('https://api.pricelabs.co/v1/listing_prices', [
                  'headers' => [
                      'X-API-Key' => env('PRICELABS_API_KEY'),
                      'Content-Type' => 'application/json',
                  ],
                  'json' => ['listings' => $listings]
              ]);

              $data = json_decode($response->getBody(), true);
              
              $availableDepartments = [];

              foreach ($data as $department) {
                  // Si la respuesta contiene un error, ignorarlo
                  if (isset($department['error'])) {
                      continue;
                  }
      
                  $allAvailable = true; // Variable para verificar si todas las fechas están disponibles
                  foreach ($department['data'] as $availability) {
                      // Verificar si alguna de las fechas tiene el estado "Booked"
                      if (strpos($availability['booking_status'], 'Booked') !== false) {
                          $allAvailable = false; // Si alguna fecha está reservada, marcamos como no disponible
                          break; // Salir del loop si encontramos una fecha "Booked"
                      }
                  }
      
                  // Si todas las fechas están disponibles, añadir el departamento a la lista
                  if ($allAvailable) {
                      $availableDepartments[] = $department['id'];
                  }
              }

            
          } catch (\Exception $e) {
              return response()->json([
                  'error' => 'Solicitud fallida',
                  'desc' => $e->getMessage(),
              ], 400);
          }

        $query->whereIn('sku', $availableDepartments);
    }

    $products = $query->orderBy('id', 'desc')->get();
    
    if ($products->isEmpty()) { 
       $mensaje = 'No se encontraron departamentos que coincidan con los filtros.'; 
       $encontrados = false;
    }else{
       $mensaje = 'Se encontraron departamentos que coinciden con los filtros.'; 
       $encontrados = true;
    }

    
    return response()->json([
      'message' => $mensaje,
      'data' => $products,
      'encontrados' => $encontrados
    ]);
  }

  public function ofertas(Request $request, string $id_cat = null)
  {
    $subCatId = $request->input('subcategoria');

    // $categories = Category::where('visible', true)->get();

    $categories = Category::with(['subcategories' => function ($query) {
      $query->whereHas('products');
    }])->where('visible', true)->get();

    $tags = Tag::where('visible', true)->get();

    $minPrice = Products::select()
      ->where('visible', true)
      ->where('descuento', '>', 0)
      ->min('descuento');
    if ($minPrice) Products::where('visible', true)->min('precio');
    $maxPrice = Products::max('precio');

    $attribute_values = AttributesValues::select('attributes_values.*')
      ->with('attribute')
      ->join('attributes', 'attributes.id', '=', 'attributes_values.attribute_id')
      ->where('attributes_values.visible', true)
      ->where('attributes.visible', true)
      ->get();

    return Inertia::render('Catalogo', [
      'component' => 'Ofertas',
      'minPrice' => $minPrice,
      'maxPrice' => $maxPrice,
      'categories' => $categories,
      'tags' => $tags,
      'attribute_values' => $attribute_values,
      'id_cat' => $id_cat
    ])->rootView('app');
  }
  public function nosotros(){
    $nosotros = AboutUs::all();
    $nosotrostextos = NosotrosView::first();
    $estadisticas = ClientLogos::where('status', '=', 1)->where('visible', '=', 1)->get();
    return view('public.nosotros' , compact('nosotros','nosotrostextos','estadisticas'));
  }


  public function comentario()
  {
    $comentarios = Testimony::where('status', '=', 1)->where('visible', '=', 1)->paginate(15);
    $categorias = Category::all();
    $contarcomentarios = count($comentarios);
    $url_env = env('APP_URL');
    $destacados = Products::where('destacar', '=', 1)->where('status', '=', 1)
      ->where('visible', '=', 1)->with('tags')->activeDestacado()->get();
    return view('public.comentario', compact('comentarios', 'contarcomentarios', 'url_env', 'categorias', 'destacados'));
  }

  public function hacerComentario(Request $request)
  {
    $user = auth()->user();

    $newComentario = new Testimony();
    if (isset($user)) {
      $alert = null;
      $request->validate([
        'testimonie' => 'required',
      ], [
        'testimonie.required' => 'Ingresa tu comentario',
      ]);

      $newComentario->name = $user->name;
      $newComentario->testimonie = $request->testimonie;
      $newComentario->visible = 0;
      $newComentario->status = 1;
      $newComentario->email = $user->email;
      $newComentario->save();

      $mensaje = "Gracias. Tu comentario pasará por una validación y será publicado.";
      $alert = 1;
    } else {
      $alert = 2;
      $mensaje = "Inicia sesión para hacer un comentario";
    }

    return redirect()->route('comentario')->with(['mensaje' => $mensaje, 'alerta' => $alert]);
  }

  public function contacto()
  {
    $general = General::first();
    $textoshome = HomeView::first();
    $categorias = Category::all();
    $url_env = env('APP_URL');
    $destacados = Products::where('destacar', '=', 1)->where('status', '=', 1)
      ->where('visible', '=', 1)->with('tags')->activeDestacado()->get();

    return view('public.contact', compact('textoshome', 'general', 'url_env', 'categorias', 'destacados'));
  }

  public function carrito()
  {
    //
    $destacados = Products::where('destacar', '=', 1)->where('status', '=', 1)
      ->where('visible', '=', 1)->with('tags')->activeDestacado()->get();
    $categorias = Category::all();
    $url_env = env('APP_URL');
    return view('public.checkout_carrito', compact('url_env', 'categorias', 'destacados'));
  }

  public function pago()
  {
    //
    $detalleUsuario = [];
    $user = auth()->user();

    if (!is_null($user)) {
      $detalleUsuario = UserDetails::where('email', $user->email)->get();
    }

    // $departamento = DB::select('select * from departments where active = ? order by 2', [1]);
    $departments = Price::select([
      'departments.id AS id',
      'departments.description AS description',
    ])
      ->join('districts', 'districts.id', 'prices.distrito_id')
      ->join('provinces', 'provinces.id', 'districts.province_id')
      ->join('departments', 'departments.id', 'provinces.department_id')
      ->where('departments.active', 1)
      ->where('status', 1)
      ->groupBy('id', 'description')
      ->get();

    $provinces = Price::select([
      'provinces.id AS id',
      'provinces.description AS description',
      'provinces.department_id AS department_id'
    ])
      ->join('districts', 'districts.id', 'prices.distrito_id')
      ->join('provinces', 'provinces.id', 'districts.province_id')
      ->where('provinces.active', 1)
      ->groupBy('id', 'description', 'department_id')
      ->get();

    $districts = Price::select([
      'districts.id AS id',
      'districts.description AS description',
      'districts.province_id AS province_id',
      'prices.id AS price_id',
      'prices.price AS price'
    ])
      ->join('districts', 'districts.id', 'prices.distrito_id')
      ->where('districts.active', 1)
      ->groupBy('id', 'description', 'province_id', 'price', 'price_id')
      ->get();

    // $distritos  = DB::select('select * from districts where active = ? order by 3', [1]);
    // $provincias = DB::select('select * from provinces where active = ? order by 3', [1]);

    $categorias = Category::all();

    $destacados = Products::where('destacar', '=', 1)->where('status', '=', 1)
      ->where('visible', '=', 1)->with('tags')->activeDestacado()->get();


    $url_env = env('APP_URL');
    $culqi_public_key = env('CULQI_PUBLIC_KEY');

    $addresses = [];
    $hasDefaultAddress = false;
    if (Auth::check()) {
      $addresses = Address::with([
        'price',
        'price.district',
        'price.district.province',
        'price.district.province.department'
      ])
        ->where('email', $user->email)
        ->get();
      $hasDefaultAddress = Address::where('email', $user->email)
        ->where('isDefault', true)
        ->exists();
    }

    return view('public.checkout_pago', compact('url_env', 'districts', 'provinces', 'departments', 'detalleUsuario', 'categorias', 'destacados', 'culqi_public_key', 'addresses', 'hasDefaultAddress'));
  }

  public function procesarPago(Request $request)
  {
    $response = new Response();
    $culqi = new Culqi(['api_key' => env('CULQI_PRIVATE_KEY')]);
    try {

      $charge = $culqi->Charges->create([
        "amount" => 1000,
        "capture" => true,
        "currency_code" => "PEN",
        "description" => "Compra en " . env('APP_NAME'),
        "email" => "test@culqi.com",
        "installments" => 0,
        "antifraud_details" => array(
          "address" => "Av. Lima 123",
          "address_city" => "LIMA",
          "country_code" => "PE",
          "first_name" => "Test_Nombre",
          "last_name" => "Test_apellido",
          "phone_number" => "9889678986",
        ),
        "source_id" => "{token_id o card_id}"
      ]);
      $response->status = 200;
      $response->message = 'El cargo se ha generado correctamente';
    } catch (\Throwable $th) {
      $response->status = 400;
      $response->message = $th->getMessage();
    } finally {
      return response($response->toArray(), $response->status);
    }
    $codigoAleatorio = '';
    $mensajes2compra = [
      'email.required' => 'El campo Email es obligatorio.',
      'nombre.required' => 'El campo Nombre es obligatorio.',
      'apellidos.required' => 'El campo Email es obligatorio.',
      'departamento_id.required ' => 'Seleccione un Departamento es obligatorio.',
      'provincia_id.required' => 'Seleccione una Provincia es obligatorio.',
      'distrito_id.required' => 'Seleccione un Distrito obligatorio.',
      'dir_av_calle.required' => 'El campo Avenida/Calle obligatorio.',
      'dir_numero.required' => 'El campo Numero es obligatorio.'
    ];

    try {
      $reglasPrimeraCompra = [
        'email' => 'required',
      ];
      $mensajes = [
        'email.required' => 'El campo Email es obligatorio.',

      ];
      $request->validate($reglasPrimeraCompra, $mensajes);

      $email = $request->email;
      $existeUser = UserDetails::where('email', $email)->get()->toArray();

      if (count($existeUser) === 0) {
        UserDetails::create($request->all());
        $datos = $request->all();
        $codigoAleatorio = $this->codigoVentaAleatorio();
        $this->guardarOrden();
        $this->envioCorreoCompra($datos);
        return response()->json(['message' => 'Data procesada correctamente', 'codigoCompra' => $codigoAleatorio],);
      } else {
        $existeUsuario = User::where('email', $email)->get()->toArray();

        if ($existeUsuario) {
          $validator = Validator::make($request->all(), [
            'email' => 'required',
            'nombre' => 'required',
            'apellidos' => 'required',
            'departamento_id' => 'required',
            'provincia_id' => 'required',
            'distrito_id' => 'required',
            'dir_av_calle' => 'required',
            'dir_numero' => 'required',
            'dir_bloq_lote' => 'required',
            // Otras reglas de validación
          ]);

          if ($validator->fails()) {
            // Aquí puedes manejar el error como desees, por ejemplo, devolver una respuesta con los errores
            return response()->json(['errors' => $validator->errors()], 422);
          } else {
            $datos = $request->all();
            //Procesar Compra
            $userdetailU = UserDetails::where('email', $email)->first();
            $userdetailU->update($request->all());

            $codigoAleatorio = $this->codigoVentaAleatorio();
            $this->guardarOrden();
            $this->envioCorreoCompra($datos);
            return response()->json(['message' => 'Todos los datos estan correctos', 'codigoCompra' => $codigoAleatorio],);
          }
        } else {
          return response()->json(['errors' => 'Por favor registrese e inicie session '], 422);
        }
      }
    } catch (\Throwable $th) {
      //throw $th;
      return response()->json(['message' => $th], 400);
    }
  }

  private function guardarOrden()
  {
    //almacenar venta, generar orden de pedido , guardar en tabla detalle de compra, li
  }

  private function codigoVentaAleatorio()
  {
    $codigoAleatorio = '';

    // Longitud deseada del código
    $longitudCodigo = 10;

    // Genera un código aleatorio de longitud 10
    for ($i = 0; $i < $longitudCodigo; $i++) {
      $codigoAleatorio .= mt_rand(0, 9); // Agrega un dígito aleatorio al código
    }
    return $codigoAleatorio;
  }

  public function agradecimiento(Request $request)
  {
    if (!$request->code) return redirect('/');

    $categorias = Category::all();
    return view('public.checkout_agradecimiento')
      ->with('categorias', $categorias)
      ->with('code', $request->code);
  }

  public function cambiofoto(Request $request)
  {


    $user = User::findOrFail($request->id);

    if ($request->hasFile("image")) {

      $file = $request->file('image');
      $route = 'storage/images/users/';
      $nombreImagen = Str::random(10) . '_' . $file->getClientOriginalName();

      if (File::exists(storage_path() . '/app/public/' . $user->profile_photo_path)) {
        File::delete(storage_path() . '/app/public/' . $user->profile_photo_path);
      }

      $this->saveImg($file, $route, $nombreImagen);

      $routeforshow = 'images/users/';
      $user->profile_photo_path = $routeforshow . $nombreImagen;

      $user->save();

      return response()->json(['message' => 'La imagen se cargó correctamente.']);
    }
  }

  public function actualizarPerfil(Request $request)
  {

    $name = $request->name;
    $lastname = $request->lastname;
    $email = $request->email;
    $phone = $request->phone;
    $user = User::findOrFail($request->id);


    if ($request->password !== null || $request->newpassword !== null || $request->confirmnewpassword !== null) {
      if (!Hash::check($request->password, $user->password)) {
        $imprimir = "La contraseña actual no es correcta";
        $alert = "error";
      } else {
        $user->password = Hash::make($request->newpassword);
        $imprimir = "Cambio de contraseña exitosa";
        $alert = "success";
      }
    }


    if ($user->name == $name &&  $user->lastname == $lastname && $user->email == $email && $user->phone == $phone) {
      $imprimir = "Sin datos que actualizar";
      $alert = "question";
    } else {
      $user->name = $name;
      $user->lastname = $lastname;
      $user->email = $email;
      $user->phone = $phone;
      $alert = "success";
      $imprimir = "Datos actualizados";
    }


    $user->save();
    return response()->json(['message' => $imprimir, 'alert' => $alert]);
  }

  public function micuenta()
  {
    $user = Auth::user();
    $categorias = Category::all();
    return view('public.dashboard', compact('user', 'categorias'));
  }


  public function pedidos()
  {
    $user = Auth::user();
    $categorias = Category::all();
    $statuses = [];
    return view('public.dashboard_order',  compact('user', 'categorias', 'statuses'));
  }

  public function listadeseos()
  {
    $user = Auth::user();


    $usuario = User::find($user->id);

    $wishlistItems = $usuario->wishlistItems()->with('products')->get();
    $arrayWishlist = $wishlistItems->toArray();
    $array = [];
    foreach ($arrayWishlist as $key => $value) {
      $array[] = $value['products']['id'];
    }


    $productos = Products::with('tags')->whereIn('id', $array)->get();
    return view('public.dashboard_wishlist', compact('user', 'wishlistItems', 'productos'));
  }


  public function searchProduct(Request $request)
  {
    $query = $request->input('query');
    $resultados = Products::select('products.*')
      ->where('producto', 'like', "%$query%")
      ->join('categories', 'categories.id', 'products.categoria_id')
      ->where('categories.visible', 1)
      ->get();



    return response()->json($resultados);
  }

  public function direccion()
  {
    $user = Auth::user();
    $addresses = Address::with([
      'price.district',
      'price.district.province',
      'price.district.province.department'
    ])
      ->where('email', $user->email)
      ->get();

    $departments = Price::select([
      'departments.id AS id',
      'departments.description AS description',
    ])
      ->join('districts', 'districts.id', 'prices.distrito_id')
      ->join('provinces', 'provinces.id', 'districts.province_id')
      ->join('departments', 'departments.id', 'provinces.department_id')
      ->where('departments.active', 1)
      ->groupBy('id', 'description')
      ->get();

    $provinces = Price::select([
      'provinces.id AS id',
      'provinces.description AS description',
      'provinces.department_id AS department_id'
    ])
      ->join('districts', 'districts.id', 'prices.distrito_id')
      ->join('provinces', 'provinces.id', 'districts.province_id')
      ->where('provinces.active', 1)
      ->groupBy('id', 'description', 'department_id')
      ->get();

    $districts = Price::select([
      'districts.id AS id',
      'districts.description AS description',
      'districts.province_id AS province_id',
      'prices.id AS price_id',
      'prices.price AS price'
    ])
      ->join('districts', 'districts.id', 'prices.distrito_id')
      ->where('districts.active', 1)
      ->groupBy('id', 'description', 'province_id', 'price', 'price_id')
      ->get();
    $categorias = Category::all();

    return view('public.dashboard_direccion', compact('user', 'addresses', 'categorias', 'departments', 'provinces', 'districts'));
  }

  public function error()
  {
    //
    return view('public.404');
  }

  public function getPrices(Request $request){
    
      $serviciosseleccionados = [];
      $client = new Client();
      $serviciosseleccionados = $request->servicios;
      $department = Products::where('sku', '=', $request['id'])->first();
      
      $checkin = $request->input('checkin');
      $checkout = $request->input('checkout');
      
      if (!$request['id'] || !$checkin || !$checkout) {
        return response()->json([
            'error' => 'Faltan datos importantes.',
        ], 400);
      }

      $listings = [
        [
            'id' => $department->sku,
            'pms' => $department->pms,
            'dateFrom' => $checkin,
            'dateTo' => $checkout
        ]
      ];
      
      try {
        $response = $client->post('https://api.pricelabs.co/v1/listing_prices', [
            'headers' => [
                'X-API-Key' => env('PRICELABS_API_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => ['listings' => $listings]
        ]);

        $data = json_decode($response->getBody(), true);
        
        // Preparar fechas para la comparación
        $checkinDate = new \DateTime($checkin);
        $checkoutDate = new \DateTime($checkout);
        $checkoutDate->modify('-1 day');

        // Inicializar variable para sumar el costo total
        $totalCost = 0;
        

        // Iterar sobre los datos recibidos en $data
         if (!empty($data[0]['data'])) {
          foreach ($data[0]['data'] as $dayData) {
              $dayDate = new \DateTime($dayData['date']);
              
              // Verificar si la fecha del día está dentro del rango (incluyendo checkin y checkout)
              if ($dayDate >= $checkinDate && $dayDate <= $checkoutDate) {
                  // Sumar el precio de ese día al total
                  $totalCost += $dayData['price'];
              }
          }
        }

        $extrasCost = ExtraService::whereIn('id', $serviciosseleccionados)->get()->sum('price');
        $producto = Products::where('sku','=', $request['id'])->first();
        if ($producto) {
          $tasaLimpieza = (float) $producto->preciolimpieza;
        } else {
          $tasaLimpieza = 0.00; 
        }
        $costoTotalFinal = $extrasCost + $totalCost + $tasaLimpieza;

        return response()->json([
          'success' => true,
          'message' => 'Datos recibidos correctamente.',
          'data' => [
              // 'productSku' => $request['id'],
              // 'checkin' => $checkin,
              // 'checkout' => $checkout,
              'costoServicios'=>$extrasCost,
              'tazaLimpieza'=> $tasaLimpieza,
              'totalCost' => $totalCost,
              'costoTotalFinal' => $costoTotalFinal
              // 'datos' => $data,
              
          ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Solicitud fallida',
            'desc' => $e->getMessage(),
        ], 400);
    }

  }


  public function producto(string $id)
  {     
        $product = Products::findOrFail($id);

        $meta_title = $producto->meta_title ?? $product->producto;
        $meta_description = $producto->meta_description  ?? Str::limit(strip_tags($product->description), 160);
        $meta_keywords = $producto->meta_keywords ?? '';

        $disabledDates = [];
        

        
        // 1. Obtener fechas bloqueadas desde la base de datos
        $fechasDB = DB::table('events')
        ->where('product_id', $product->id)
        ->pluck('checkin', 'checkout');

        foreach ($fechasDB as $checkout => $checkin) {
            $startDate = Carbon::parse($checkin)->startOfDay();
            $endDate = Carbon::parse($checkout)->subDay()->startOfDay(); // Restar un día al checkout

            while ($startDate->lte($endDate)) {
                $disabledDates[] = $startDate->format('d/m/Y');
                $startDate->addDay();
            }
        }

        // 2. Obtener fechas bloqueadas desde el archivo .ics
        $icalUrl =  $product->airbnb_url;

        if ($icalUrl) {
          // Si hay un URL válido, obtenemos el contenido del archivo .ics
          $icalContent = file_get_contents($icalUrl);
          $lines = explode("\n", $icalContent);
          $startDate = null;
          $endDate = null;
          

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
                      $disabledDates[] = $startDate->format('d/m/Y');
                      $startDate->addDay();
                  }

                  // Reiniciar las variables para el siguiente evento
                  $startDate = null;
                  $endDate = null;
              }
          }
        } else {
          
          $startDate = Carbon::now();
          $endDate = Carbon::now()->addYears(5); // Puedes ajustar este rango según tus necesidades

          while ($startDate->lte($endDate)) {
              $disabledDates[] = $startDate->format('d/m/Y');
              $startDate->addDay();
          }
        }
        
        
        $disabledDates = array_unique($disabledDates);
    
        $is_reseller = false; 
        if(Auth::check()){
        $user = Auth::user();
        $is_reseller = $user->hasRole('Reseller');
     
    }

    // $productos = Products::where('id', '=', $id)->first();
    // $especificaciones = Specifications::where('product_id', '=', $id)->get();

    $especificaciones = Specifications::where('product_id', '=', $id)
      ->where(function ($query) {
        $query->whereNotNull('tittle')
          ->orWhereNotNull('specifications');
      })
      ->get();
    
    $serviciosextras = ExtraService::where('product_id', '=', $id)
    ->where(function ($query) {
      $query->whereNotNull('service')
        ->orWhereNotNull('price');
    })
    ->get();

    $productosConGalerias = DB::select("
            SELECT products.*, galeries.*
            FROM products
            INNER JOIN galeries ON products.id = galeries.product_id
            WHERE products.id = :productId limit 5 
        ", ['productId' => $id]);


    // $IdProductosComplementarios = $productos->toArray();
    // $IdProductosComplementarios = $IdProductosComplementarios[0]['categoria_id'];

    $ProdComplementarios = Products::select()
      ->where('id', '<>', $id)
      ->where('categoria_id', '=', $product->categoria_id)
      ->where('status', '=', true)
      ->where('visible', '=', true)
      ->inRandomOrder()
      ->take(3)
      ->get();
    $atributos = Attributes::where("status", "=", true)->get();
    $valorAtributo = AttributesValues::where("status", "=", true)->get();
    $valoresdeatributo = AttributeProductValues::where("product_id", "=", $id)->get();
    $url_env = env('APP_URL');

    $capitalizeFirstLetter = function ($string) {
      // Convert the entire string to lowercase
      $string = strtolower($string);
      // Capitalize the first letter and concatenate with the rest of the string
      return ucfirst($string);
    };

    $categorias = Category::all();

    $destacados = Products::where('destacar', '=', 1)->where('status', '=', 1)
      ->where('visible', '=', 1)->with('tags')->activeDestacado()->get();

    $otherProducts = Products::select()
      ->where('id', '<>', $id)
      ->where('producto', $product->producto)
      ->whereNotNull('color')
      ->get();

    $galery = Galerie::where('product_id', $product->id)->get();

    $general = General::first();
    $testimonios = Testimony::where('status', '=', 1)->where('visible', '=', 1)->get();
    $isWhishList = false;
    if (Auth::check()) {
      $user = Auth::user();
      $exite = Wishlist::where('user_id', $user->id)->where('product_id', $id)->first();
      if ($exite) {
        $isWhishList = true;
      }
    }

    $departamento = Department::where('id', $product->departamento_id)->first();
    $provincia = Province::where('id', $product->provincia_id)->first();
    $distrito = District::where('id', $product->distrito_id)->first();

    $combo = Offer::select([
      DB::raw('DISTINCT offers.*')
    ])
      ->with('products')
      ->leftJoin('offer_details', 'offers.id', 'offer_details.offer_id')
      ->where('offer_details.isParent', true)
      ->where('offer_details.product_id', $id)
      ->first();

    if (!$combo) $combo = new Offer();

    return view('public.product', compact('meta_title','meta_description','meta_keywords', 'serviciosextras','disabledDates', 'departamento', 'provincia', 'distrito', 'is_reseller', 'atributos', 'isWhishList', 'testimonios', 'general', 'valorAtributo', 'ProdComplementarios', 'productosConGalerias', 'especificaciones', 'url_env', 'product', 'capitalizeFirstLetter', 'categorias', 'destacados', 'otherProducts', 'galery', 'combo', 'valoresdeatributo'));
  }

  public function wishListAdd(Request $request)
  {
    $user = Auth::user();

    $exite = Wishlist::where('user_id', $user->id)->where('product_id', $request->product_id)->first();
    if ($exite) {
      Wishlist::find($exite->id)->delete();
      return response()->json(['message' => 'El producto ya se encuentra en la lista de deseos']);
    } else {
      $whistList = Wishlist::create([
        'user_id' => $user->id,
        'product_id' => $request->product_id,
        'quantity' => 1,
        'note' => ''
      ]);
    }


    return response()->json(['message' => 'Producto agregado a la lista de deseos']);
  }


  //  --------------------------------------------
  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreIndexRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Index $index)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Index $index)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateIndexRequest $request, Index $index)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Index $index)
  {
    //
  }

  /**
   * Save contact from blade
   */
  public function guardarContacto(Request $request)
  {

    $data = $request->all();
    $data['full_name'] = $request->name . ' ' . $request->last_name;

    try {
      $reglasValidacion = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
      ];
      $mensajes = [
        'name.required' => 'El campo nombre es obligatorio.',
        'email.required' => 'El campo correo electrónico es obligatorio.',
        'email.email' => 'El formato del correo electrónico no es válido.',
        'email.max' => 'El campo correo electrónico no puede tener más de :max caracteres.',
      ];
      $request->validate($reglasValidacion, $mensajes);
      $formlanding = Message::create($data);
      $this->envioCorreo($formlanding);

      return response()->json(['message' => 'Mensaje enviado con exito']);
    } catch (ValidationException $e) {

      return response()->json(['message' => $e->validator->errors()], 400);
    }
  }



  public function saveImg($file, $route, $nombreImagen)
  {
    $manager = new ImageManager(new Driver());
    $img =  $manager->read($file);

    if (!file_exists($route)) {
      mkdir($route, 0777, true); // Se crea la ruta con permisos de lectura, escritura y ejecución
    }
    $img->save($route . $nombreImagen);
  }


  private function envioCorreo($data)
  {
    $appUrl = env('APP_URL');
    $name = $data['full_name'];
    $mensaje = "Gracias por comunicarte con Ventura";
    $mail = EmailConfig::config($name, $mensaje);
    // dd($mail);
    try {
      $mail->addAddress($data['email']);
      $mail->Body = '<html lang="es">
        <head>
          <meta charset="UTF-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <title>Mundo web</title>
          <link rel="preconnect" href="https://fonts.googleapis.com" />
          <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
          <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet"
          />
          <style>
            * {
              margin: 0;
              padding: 0;
              box-sizing: border-box;
            }
          </style>
        </head>
        <body>
          <main>
            <table
              style="
                width: 600px;
                height: 800px;
                margin: 0 auto;
                text-align: center;
                background-image:url(' . $appUrl . '/images/Ellipse_18.png),  url(' . $appUrl . '/images/Tabpanel.png);
                background-repeat: no-repeat, no-repeat;
                background-position: center bottom , center bottom;;
                background-size: fit , fit;
                background-color: #f9f9f9;
              "
            >
              <thead>
                <tr>
                  <th
                    style="
                      display: flex;
                      flex-direction: row;
                      justify-content: center;
                      align-items: center;
                      margin: 40px;
                    "
                  >
                    <img src="' . $appUrl . '/images/Group1.png" alt="Boost_Peru"  style="
                    margin: auto;
                  "/>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="height: 10px">
                    <p
                      style="
                        
                        font-weight: 500;
                        font-size: 18px;
                        text-align: center;
                        width: 500px;
                        margin: 0 auto;
                        font-family: Montserrat, sans-serif;
                        line-height: 30px;
                      "
                    >
                      <span style="display: block">Hola </span>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td style="height: 10px">
                    <p
                      style="
                        
                        font-size: 40px;
                        font-family: Montserrat, sans-serif;
                        line-height: 60px;
                      "
                    >
                      <span style="display: block">' . $name . ' </span>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td style="height: 10px">
                    <p
                      style="
                        color: #006bf6;
                        font-size: 40px;
                        font-family: Montserrat, sans-serif;
                        font-weight: bold;
                        line-height: 60px;
                      "
                    >
                      !Gracias
                      <span >por escribirnos!</span>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td style="height: 10px">
                    <p
                      style="
                        
                        font-weight: 500;
                        font-size: 18px;
                        text-align: center;
                        width: 250px;
                        margin: 0 auto;
                        font-family: Montserrat, sans-serif;
                        line-height: 30px;
                      "
                    >
                      En breve estaremos comunicandonos contigo.
                    </p>
                  </td>
                </tr>
                <tr>
                  <td
                    style="
                    text-align: center;
                  "
                  >
                    <a
                      href="' . $appUrl . '"
                      style="
                        text-decoration: none;
                        background-color: #006bf6;
                        color: white;
                        padding: 10px 16px;
                        display: inline-flex;
                        justify-content: center;
                        align-items: center;
                        gap: 10px;
                        font-weight: 600;
                        font-family: Montserrat, sans-serif;
                        font-size: 16px;
                        border-radius: 30px;
                      "
                    >
                      <span>Visita nuestra web</span>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </main>
        </body>
      </html>
      ';
      // $mail->addBCC('atencionalcliente@boostperu.com.pe', 'Atencion al cliente', );
      // $mail->addBCC('jefecomercial@boostperu.com.pe', 'Jefe Comercial', );
      $mail->isHTML(true);
      $mail->send();
    } catch (\Throwable $th) {
      //throw $th;
    }
  }

  public function envioCorreoCompra($data)
  {

    $appUrl = env('APP_URL');
    $name = $data['nombre'];
    $mensaje = "Gracias por comprar en $appUrl ";
    $mail = EmailConfig::config($name, $mensaje);
    try {
      $mail->addAddress($data['email']);
      $mail->Body = '<html lang="es">
        <head>
          <meta charset="UTF-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <title>Mundo web</title>
          <link rel="preconnect" href="https://fonts.googleapis.com" />
          <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
          <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet"
          />
          <style>
            * {
              margin: 0;
              padding: 0;
              box-sizing: border-box;
            }
          </style>
        </head>
        <body>
          <main>
            <table
              style="
                width: 600px;
                height: 900px;
                margin: 0 auto;
                text-align: center;
                 background-image:url(' . $appUrl . '/images/Ellipse_18.png),  url(' . $appUrl . '/images/Tabpanel.png);
                background-repeat: no-repeat, no-repeat;
                background-position: center bottom , center bottom;;
                background-size: fit , fit;
                background-color: #f9f9f9;
              "
            >
              <thead>
                <tr>
                  <th
                    style="
                      display: flex;
                      flex-direction: row;
                      justify-content: center;
                      align-items: center;
                      margin: 40px;
                    "
                  >
                     <img src="' . $appUrl . '/images/Group1.png" alt="Boost_Peru"  style="
                    margin: auto;
                  "/>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="height: 10px">
                    <p
                      style="
                        color: #4d86c3;
                        font-weight: 500;
                        font-size: 18px;
                        text-align: center;
                        width: 500px;
                        margin: 0 auto;
                        font-family: Montserrat, sans-serif;
                        line-height: 30px;
                      "
                    >
                      <span style="display: block">Hola </span>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td style="height: 10px">
                    <p
                      style="
                        color: #4d86c3;
                        font-size: 40px;
                        font-family: Montserrat, sans-serif;
                        line-height: 60px;
                      "
                    >
                      <span style="display: block">' . $name . ' </span>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td style="height: 10px">
                    <p
                      style="
                        color: #006bf6;
                        font-size: 40px;
                        font-family: Montserrat, sans-serif;
                        font-weight: bold;
                        line-height: 60px;
                      "
                    >
                      !Gracias
                      <span style="color: #4d86c3">por tu Compra!</span>
                    </p>
                  </td>
                </tr>
                <tr>
                  <td style="height: 10px">
                    <p
                      style="
                        color: #4d86c3;
                        font-weight: 500;
                        font-size: 18px;
                        text-align: center;
                        width: 250px;
                        margin: 0 auto;
                        font-family: Montserrat, sans-serif;
                        line-height: 30px;
                      "
                    >
                      En breve momentos estaremos procesando tu pedido.
                    </p>
                  </td>
                </tr>
                <tr>
                <td
                  style="
                  text-align: center;
                "
                >
                    <a
                      href="' . $appUrl . '"
                      style="
                        text-decoration: none;
                        background-color: #006bf6;
                        color: white;
                        padding: 10px 16px;
                        display: inline-flex;
                        justify-content: center;
                        align-items: center;
                        gap: 10px;
                        font-weight: 600;
                        font-family: Montserrat, sans-serif;
                        font-size: 16px;
                        border-radius: 30px;
                      "
                    >
                      <span>Visita nuestra web</span>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </main>
        </body>
      </html>
      ';
      // $mail->addBCC('atencionalcliente@boostperu.com.pe', 'Atencion al cliente', );
      // $mail->addBCC('jefecomercial@boostperu.com.pe', 'Jefe Comercial', );
      $mail->isHTML(true);
      $mail->send();
    } catch (\Throwable $th) {
      //throw $th;
    }
  }

  public function librodereclamaciones()
  {
    $departamentofiltro = DB::select('select * from departments where active = ? order by 2', [1]);

    return view('public.librodereclamaciones', compact('departamentofiltro'));
  }

  public function obtenerProvincia($departmentId)
  {
    $provinces = DB::select('select * from provinces where active = ? and department_id = ? order by description', [1, $departmentId]);
    return response()->json($provinces);
  }

  public function obtenerDistritos($provinceId)
  {
    $distritos = DB::select('select * from districts where active = ? and province_id = ? order by description', [1, $provinceId]);
    return response()->json($distritos);
  }

  public function politicasDevolucion()
  {
    $politicDev = PolyticsCondition::first();
    return view('public.politicasdeenvio', compact('politicDev'));
  }

  public function TerminosyCondiciones()
  {
    $termsAndCondicitions = TermsAndCondition::first();
    return view('public.terminosycondiciones', compact('termsAndCondicitions'));
  }

  public function blog($filtro)
  {
    try {
      $categorias = Category::where('status', '=', 1)->where('visible', '=', 1)->get();

      if ($filtro == 0) {
        $posts = Blog::where('status', '=', 1)->where('visible', '=', 1)->get();

        $categoria = Category::where('status', '=', 1)->where('visible', '=', 1)->get();

        $lastpost = Blog::where('status', '=', 1)->where('visible', '=', 1)->orderBy('created_at', 'desc')->first();
      } else {
        $posts = Blog::where('status', '=', 1)->where('visible', '=', 1)->where('category_id', '=', $filtro)->get();

        $categoria = Category::where('status', '=', 1)->where('visible', '=', 1)->where('id', '=', $filtro)->get();

        $lastpost = Blog::where('status', '=', 1)->where('visible', '=', 1)->orderBy('created_at', 'desc')->where('category_id', '=', $filtro)->first();
      }

      return view('public.blogs', compact('posts', 'categoria', 'categorias', 'filtro', 'lastpost'));
    } catch (\Throwable $th) {
    }
  }

  public function detalleBlog($id)
  {
    $post = Blog::where('status', '=', 1)->where('visible', '=', 1)->where('id', '=', $id)->first();
    $meta_title = $post->meta_title ?? $post->title;
    $meta_description = $post->meta_description  ?? Str::limit($post->extract, 160);
    $meta_keywords = $post->meta_keywords ?? '';

    return view('public.post', compact('meta_title', 'meta_description', 'meta_keywords', 'post'));
  }


  public function searchBlog(Request $request)
  {
    $query = $request->input('query');

    $resultados = Blog::where('title', 'like', "%$query%")->where('visible', '=', true)->where('status', '=', true)
      ->get();

    return response()->json($resultados);
  }


  public function help()
  { 
    $faqs = Faqs::where('status', '=', 1)->where('visible', '=', 1)->get();
    $url_env = env('APP_URL');
    return view('public.help', compact('url_env','faqs'));
  }
}

