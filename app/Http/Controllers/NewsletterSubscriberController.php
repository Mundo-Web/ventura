<?php

namespace App\Http\Controllers;

use App\Helpers\EmailConfig;
use App\Models\General;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterSubscriberController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
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
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(NewsletterSubscriber $newsletterSubscriber)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(NewsletterSubscriber $newsletterSubscriber)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, String $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(NewsletterSubscriber $newsletterSubscriber)
  {
    //
  }

  public function showSubscripciones()
  {
    $subscripciones = NewsletterSubscriber::orderBy('created_at', 'desc')->get();

    return view('pages.subscripciones.index', compact('subscripciones'));
  }

  public function guardarUserNewsLetter(Request $request)
  {
    NewsletterSubscriber::create($request->all());
    $data = $request->all();
    $data['nombre'] = '';
    $this->envioCorreo($data);
    $this->envioCorreoAdmin();
    return response()->json(['message' => 'Usuario suscrito']);
  }

  private function envioCorreo($data)
  {
    $appUrl = env('APP_URL');
    $appName = env('APP_NAME');
    $name = 'estimado usuario';
    $mensaje = "Gracias por suscribirte en $appName";
    $mail = EmailConfig::config($name, $mensaje);

    try {
      $mail->addAddress($data['email']);
      $mail->Body = '<html lang="en">
      <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Ventura</title>
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
              margin: 0 auto;
              text-align: center;
              background-image: url(' .
                    $appUrl .
                    '/mail/fondo.png);
              background-repeat: no-repeat;
              background-position: center;
              background-size: cover;
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
                    margin-top: 40px;
                    padding: 0 200px;
                  "
                >
                    <a href="' .
                    $appUrl .
                    '" target="_blank" style="text-align:center" ><img src="' .
                    $appUrl .
                    '/mail/logo.png"/></a>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <p
                    style="
                      color: #002677;
                      font-size: 40px;
                      line-height: normal;
                      font-family: Roboto;
                      font-weight: bold;
                    "
                  >
                    ¡Suscripción
                    <span style="color: #002677">realizada!</span>
                  </p>
                </td>
              </tr>

              <tr>
                <td>
                  <p
                    style="
                      color: #002677;
                      font-weight: 500;
                      font-size: 18px;
                      text-align: center;
                      width: 500px;
                      margin: 0 auto;
                      padding: 20px 0 5px 0;
                      font-family: Roboto;
                    "
                  >
                    <span style="display: block">Hola ' . $name . '</span>
                  </p>
                </td>
              </tr>
              
              <tr>
                <td>
                  <p
                    style="
                      color: #002677;
                      font-weight: 500;
                      font-size: 18px;
                      text-align: center;
                      width: 500px;
                      margin: 0 auto;
                      padding: 0px 10px 5px 0px;
                      font-family: Roboto;
                    "
                  >
                    Pronto recibirás nuestras últimas noticias, artículos y promociones directamente en tu correo.
                  </p>
                </td>
              </tr>
              <tr>
                <td>
                  <a
                      target="_blank"
                    href="' .
                    $appUrl .
                    '"
                    style="
                      text-decoration: none;
                      background: #00897B;
                      color: #73F7AD;
                      padding: 13px 20px;
                      display: inline-flex;
                      justify-content: center;
                      border-radius: 16px;
                      align-items: center;
                      gap: 10px;
                      font-weight: 600;
                      font-family: Roboto;
                      font-size: 16px;
                      margin-bottom: 350px;
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
      $mail->isHTML(true);
      $mail->send();
    } catch (\Throwable $th) {
      //throw $th;
      // dump($th);
    }
  }

  private function envioCorreoAdmin()
    {
        $emailadmin = General::first()->email;
        $appUrl = env('APP_URL');
        $name = 'Administrador';
        $mensaje = 'Tienes un nuevo suscriptor - Ventura';
        $mail = EmailConfig::config($name, $mensaje);
        try {
            $mail->addAddress($emailadmin);
            $mail->Body =
                '<html lang="en">
                    <head>
                      <meta charset="UTF-8" />
                      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                      <title>Ventura</title>
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
                            margin: 0 auto;
                            text-align: center;
                            background-image: url(' .
                              $appUrl .
                              '/mail/fondo.png);
                            background-repeat: no-repeat;
                            background-position: center;
                            background-size: cover;
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
                                  margin-top: 40px;
                                  padding: 0 200px;
                                "
                              >
                                  <a href="' .
                              $appUrl .
                              '" target="_blank" style="text-align:center" ><img src="' .
                              $appUrl .
                              '/mail/logo.png"/></a>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>
                                <p
                                  style="
                                    color: #002677;
                                    font-size: 40px;
                                    line-height: normal;
                                    font-family: Roboto;
                                    font-weight: bold;
                                  "
                                >
                                  ¡Nuevo 
                                  <span style="color: #002677">suscriptor en venturabnb.pe!</span>
                                </p>
                              </td>
                            </tr>

                            <tr>
                              <td>
                                <p
                                  style="
                                    color: #002677;
                                    font-weight: 500;
                                    font-size: 18px;
                                    text-align: center;
                                    width: 500px;
                                    margin: 0 auto;
                                    padding: 20px 0 5px 0;
                                    font-family: Roboto;
                                  "
                                >
                                  <span style="display: block">Hola ' .
                              $name .
                              '</span>
                                </p>
                              </td>
                            </tr>
                            
                            <tr>
                              <td>
                                <p
                                  style="
                                    color: #002677;
                                    font-weight: 500;
                                    font-size: 18px;
                                    text-align: center;
                                    width: 500px;
                                    margin: 0 auto;
                                    padding: 0px 10px 5px 0px;
                                    font-family: Roboto;
                                  "
                                >
                                  Tienes un nuevo suscriptor, para mas detalle revisar tu panel de administración.
                                </p>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <a
                                    target="_blank"
                                  href="' .
                              $appUrl .
                              '/login"
                                  style="
                                    text-decoration: none;
                                    background: #00897B;
                                    color: #73F7AD;
                                    padding: 13px 20px;
                                    display: inline-flex;
                                    justify-content: center;
                                    border-radius: 32px;
                                    align-items: center;
                                    gap: 10px;
                                    font-weight: 600;
                                    font-family: Roboto;
                                    font-size: 16px;
                                    margin-bottom: 350px;
                                  "
                                >
                                  <span>Ir a panel de administración</span>
                                </a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </main>
                    </body>
                  </html>
                    ';
            $mail->isHTML(true);
            $mail->send();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

  public function envioMasivo($plantilla){
    try {
      //code...
      $subscripciones = NewsletterSubscriber::all();
      $general = General::all()->first();
      $appUrl = env('APP_URL');
      $name = '';
      $mensaje = env('APP_NAME'). 'Acaba de publicar un nuevo post';
      $mail = EmailConfig::config($name, $mensaje);
      $mail->Subject = 'Nuevo Post Publicado';
      $mail->Body = $plantilla;
      $mail->isHTML(true);
      foreach ($subscripciones as $subscripcion) {
        $mail->addBCC($subscripcion->email);
      }
      $mail->send();
      return response()->json(['message' => 'Correo enviado']);
    } catch (\Throwable $th) {
      //throw $th;
      // dump($th);
    }
   
  }
}
