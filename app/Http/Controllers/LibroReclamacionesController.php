<?php

namespace App\Http\Controllers;

use App\Helpers\EmailConfig;
use App\Models\LibroReclamaciones;
use App\Http\Requests\StoreLibroReclamacionesRequest;
use App\Http\Requests\UpdateLibroReclamacionesRequest;
use App\Models\Department;
use App\Models\District;
use App\Models\General;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;


class LibroReclamacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mensajes = LibroReclamaciones::where('status' , '=', 1 )->orderBy('created_at', 'DESC')->get();
        
        return view('pages.claim.index', compact('mensajes'));
    }

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
    public function store(StoreLibroReclamacionesRequest $request)
    {
        //
    }


    function storePublic(Request $request)
    {
        
        $validatedData = $request->validate([
            'fullname' => 'required|string',
            'type_document' => 'required|string',
            'number_document'=> 'required|string',
            'cellphone'=> 'required|numeric',
            'email'=> 'required|string',
            'department'=> 'required|string',
            'province'=> 'required|string',
            'district'=> 'required|string',
            'address'=> 'required|string',
            'typeitem'=> 'required|string',
            'amounttotal' => 'required|numeric',
            // 'category_product_service'=> 'required|string',
            'description'=> 'required|string',
            'type_claim'=> 'required|string',
            'date_incident'=> 'required|string',
            'address_incident'=> 'required|string',
            'detail_incident'=> 'required|string',
            'g-recaptcha-response' => 'required|captcha',
            
        ], [ 'g-recaptcha-response.required' => 'Por favor, completa el reCAPTCHA. Queremos asegurarnos de que no eres un robot.',
        'g-recaptcha-response.captcha' => 'El reCAPTCHA no es válido. Inténtalo de nuevo.',] );
        

        $libro = LibroReclamaciones::create($validatedData);

        $validatedData['department'] = Department::where('id', $validatedData['department'])->first()->description;
        $validatedData['province'] = Province::where('id', $validatedData['province'])->first()->description;
        $validatedData['district'] = District::where('id', $validatedData['district'])->first()->description;
        $this-> envioCorreoLibrodeReclamacion($validatedData);
        return response()->json(['message' => 'Mensaje enviado']);
        
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


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $message = LibroReclamaciones::findOrFail($id);

        $message->is_read = 1; 
        $message->save();

        return view('pages.claim.show', compact('message'));
    }

   
    public function borrar(Request $request)
    {

        $mensaje = LibroReclamaciones::find($request->id);
        $mensaje->status = 0; 
        $mensaje->save();

        return response()->json(['success' => true]);

    }


    private function envioCorreoLibrodeReclamacion($data){
        $appUrl = config('app.url');
        $appName = config('app.name');
        $name = $data['fullname'];
        $type_document = $data['type_document'];
        $number_document = $data['number_document'];
        $cellphone = $data['cellphone'];
        $email = $data['email'];
        $department = $data['department'];
        $province = $data['province'];
        $district = $data['district'];
        $address = $data['address'];
        $typeitem = $data['typeitem'];
        $amounttotal = $data['amounttotal'];
        $description = $data['description'];
        $type_claim = $data['type_claim'];
        $date_incident = $data['date_incident'];
        $address_incident = $data['address_incident'];
        $detail_incident = $data['detail_incident'];
        $mensaje = "Tu reclamo ha sido recepcionado";
        $mail = EmailConfig::config($name, $mensaje);
        $emailadmin = General::first();
        
        
        
        try {
            $mail->addAddress($data['email']);
            $mail->Body = '<html lang="es">
            <head>
              <meta charset="UTF-8" />
              <meta name="viewport" content="width=device-width, initial-scale=1.0" />
              <title>.'.$appName.'.</title>
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
                <h2> Datos de la persona </h2>
                 <hr>
                 <br>
                <p> Nombres y Apellidos: '.$name.' </p>
                <p> Tipo de documento: '.$type_document.' </p>
                <p> Número de documento: '.$number_document.' </p>
                <p> Celular: '.$cellphone.' </p>
                <p> Correo: '.$email.' </p>
                <p> Departamento: '.$department.' </p>
                <p> Provincia: '.$province.' </p>
                <p> Distrito: '.$district.' </p>
                <p> Dirección: '.$address.' </p>
                <br><br>

                <h2> Datos del reclamo </h2>
                <br>
                <hr>
                <p> Tienda: Online BoostPeru </p>
                <p> Identificacion del bien contratado: '.$typeitem.' </p>
                <p> Monto Reclamado: '.$amounttotal.' </p>
                <p> Descripción : '.$description.' </p>
                <br><br>

                
                <h2> Detalles del Reclamo </h2>
                <hr>
                <br>
                <p> Tipo de Reclamo: '.$type_claim.' </p>
                <p> Fecha del Incidente: '.$date_incident.' </p>
                <p> Numero del pedido: '.$address_incident.' </p>
                <p> Detalle del Incidente: '.$detail_incident.' </p>

                <br><br>

              <span> Acepta tratamiento de datos : Al enviar este formulario acepto el flujo de mis datos personales, segun la Ley de Proteccion de Datos Personales. </span>


              </main>
            </body>
          </html>
          ';
            $mail->addBCC($emailadmin->email, 'Administrador');
            $mail->isHTML(true);
            $mail->send();
            
        } catch (\Throwable $th) {
            //throw $th;
        }  
      }
}
