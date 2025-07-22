<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\ExtraService;
use App\Models\Offer;
use App\Models\Price;
use App\Models\Products;
use App\Models\General;
use App\Models\Sale;
use App\Models\SaleDetail;
use Culqi\Culqi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SoDe\Extend\JSON;
use SoDe\Extend\Response;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use Spatie\IcalendarGenerator\Properties\Property;
use Spatie\IcalendarGenerator\Properties\TextProperty;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use App\Helpers\EmailConfig;
use Carbon\Carbon;

class PaymentController extends Controller
{
  public function culqi(Request $request)
  {
    $body = $request->all();
    $response = new Response();
    $culqi = new Culqi(['api_key' => env('CULQI_PRIVATE_KEY')]);

    $sale = new Sale();
    $sale->code = '000000000000'; 
    $sale->status_id = 1; 
    $sale->status_message = 'La venta se ha creado. Aun no se ha pagado';

    DB::beginTransaction();

    try {

      $products = array_filter($body['cart'], fn($x) => !(isset($x['isCombo']) && $x['isCombo'] == true));
      $offers = array_filter($body['cart'], fn($x) => isset($x['isCombo']) && $x['isCombo'] == true);

      $productsJpa = []; 

      if (Auth::check() && Auth::user()->hasRole('Reseller')) {
          $productsJpa = Products::select(['id', 'imagen', 'producto', 'color', 'precio', 'sku', 'pms', 'precio_reseller as descuento', 'person_ranges'])
            ->whereIn('id', array_map(fn($x) => $x['id'], $products))
            ->get();
      }else{
        $productsJpa = Products::select(['id', 'imagen', 'producto', 'color', 'precio', 'descuento', 'preciolimpieza', 'sku', 'pms', 'person_ranges'])
        ->whereIn('id', array_map(fn($x) => $x['id'], $products))
        ->get();
      }

      $offersJpa = [];
      if (count($offers) > 0) {
        $offersJpa = Offer::select(['id', 'imagen', 'producto', DB::raw('null AS color'), 'precio', 'descuento'])
          ->whereIn('id', array_map(fn($x) => $x['id'], $offers))
          ->get();
      }

      $totalXReserva = [];
      $totalCost = 0;
      $extras = [];
     
      foreach ($productsJpa as $productJpa) {
        $key = array_search($productJpa->id, array_column($body['cart'], 'id'));
        $checkin = $body['cart'][$key]['checkin']; 
        $checkout = $body['cart'][$key]['checkout'];
        $extras = $body['cart'][$key]['extras'];
        $cantidadPersonas = $body['cart'][$key]['personas'];
        
        if (!$checkin || !$checkout) {
          continue;
        }

        $client = new \GuzzleHttp\Client();

        $listings = [
          [
              'id' => $productJpa->sku, 
              'pms' => $productJpa->pms,
              'dateFrom' => $checkin,
              'dateTo' => $checkout 
          ]
        ];

        try {
              $responsePL = $client->post('https://api.pricelabs.co/v1/listing_prices', [
                  'headers' => [
                      'X-API-Key' => 'eKmVICRiQkJJvNMZTrTWknRjvYPH34uHRJSgyeEc',
                      'Content-Type' => 'application/json',
                  ],
                  'json' => ['listings' => $listings]
              ]);
      
              $data = json_decode($responsePL->getBody(), true);
       
              $checkinDate = new \DateTime($checkin);
              $checkoutDate = new \DateTime($checkout);
              $checkoutDate->modify('-1 day'); 
             
             
              $productCost = 0;
      
              if (!empty($data[0]['data'])) {
                  foreach ($data[0]['data'] as $dayData) {
                      $dayDate = new \DateTime($dayData['date']);

                      if ($dayDate >= $checkinDate && $dayDate <= $checkoutDate) {
                          
                          $productCost += $dayData['price'];
                      }
                  }
              }

              if (is_array($extras) && count($extras) > 0) {
                  $extrasCost = ExtraService::whereIn('id', $extras)->sum('price');
              } else {
                  $extrasCost = 0; // Valor predeterminado si no hay extras
              }

              $personRanges = $productJpa->person_ranges ?? '[]';
              $extraPersonas = $this->calcularCostoPorPersonas($cantidadPersonas, $personRanges);

              //$totalCost += ($productCost + $productJpa->preciolimpieza) * $body['cart'][$key]['quantity'];
              $totalCost += $productCost + $productJpa->preciolimpieza + $extrasCost + $extraPersonas;
              $totalXReserva[$productJpa->id] = $productCost + $productJpa->preciolimpieza + $extrasCost + $extraPersonas;

          } catch (\Exception $e) {
              continue;
          }

      }

      foreach ($offersJpa as $offerJpa) {
        $key = array_search($offerJpa->id, array_column($body['cart'], 'id'));
        if ($offerJpa->descuento > 0) {
          $totalCost += $offerJpa->descuento * $body['cart'][$key]['quantity'];
        } else {
          $totalCost += $offerJpa->precio * $body['cart'][$key]['quantity'];
        }
      }

      $sale->name = $body['contact']['name'];
      $sale->lastname = $body['contact']['lastname'];
      $sale->email = Auth::check() ? Auth::user()->email : $body['contact']['email'];
      $sale->phone = $body['contact']['phone'];
      $sale->address_price = 0;
      $sale->total = $totalCost;
      $sale->tipo_comprobante = $body['tipo_comprobante'];
      $sale->doc_number = $body['contact']['doc_number'] ?? null;
      $sale->razon_fact = $body['contact']['razon_fact'] ?? null;
      $sale->direccion_fact = $body['contact']['direccion_fact'] ?? null;
      
      if ($request->address) {
        $price = Price::with([
          'district',
          'district.province',
          'district.province.department'
        ])
          ->where('prices.id', $body['address']['id'])
          ->first();

        if ($price) {
          $totalCost += $price->price;

          $sale->address_department = $price->district->province->department->description;
          $sale->address_province = $price->district->province->description;
          $sale->address_district = $price->district->description;
          $sale->address_street = $body['address']['street'];
          $sale->address_number = $body['address']['number'];
          $sale->address_description = $body['address']['description'];
          $sale->address_price = $price->price;
          try {
            if ($request->saveAddress) {
              Address::create([
                'email' =>  Auth::check() ? Auth::user()->email : $body['contact']['email'],
                'price_id' => $price->id,
                'street' =>  $body['address']['street'],
                'number' => $body['address']['number'],
                'description' => $body['address']['description'],
              ]);
            }
          } catch (\Throwable $th) {
            // dump('No se pudo guardar la direccion', $th);
          }
        }
      }

      $sale->save();

      foreach ($productsJpa as $productJpa) {
        $key = array_search($productJpa->id, array_column($body['cart'], 'id'));
        $quantity = $body['cart'][$key]['quantity'];
        $checkin = $body['cart'][$key]['checkin'];
        $checkout = $body['cart'][$key]['checkout'];
        $extras = $body['cart'][$key]['extras'];
        $cantidadPersonas = $body['cart'][$key]['personas'];
    
        if (is_array($extras) && count($extras) > 0) {
          $nombresServicios = ExtraService::whereIn('id', $extras)->pluck('service');
        } else {
          $nombresServicios = collect(); 
        }

        $extrasStr = $nombresServicios->implode(', ');

        //$price = $productJpa->descuento > 0 ? $productJpa->descuento : $productJpa->precio;
        $price = $totalXReserva[$productJpa->id]; 
        $personRanges = $productJpa->person_ranges ?? '[]';
        $extraPersonas = $this->calcularCostoPorPersonas($cantidadPersonas, $personRanges);
        
        SaleDetail::create([
          'sale_id' => $sale->id,
          'product_image' => $productJpa->imagen,
          'product_name' => $productJpa->producto,
          'product_color' => $productJpa->color,
          'checkin' => $checkin,
          'checkout' => $checkout,
          'extras' => $extrasStr,
          'quantity' => $quantity,
          'price' => $price,
          'cantidad_personas' => $cantidadPersonas,
          'extra_personas' => $extraPersonas,
        ]);
      }

      foreach ($offersJpa as $offerJpa) {
        $key = array_search($offerJpa->id, array_column($body['cart'], 'id'));
        $quantity = $body['cart'][$key]['quantity'];
        $price = $offerJpa->descuento > 0 ? $offerJpa->descuento : $offerJpa->precio;

        $name = '<b>' . $offerJpa->producto . '</b><ul class="mb-1">';

        foreach ($offerJpa->products as $productJpa) {
          $name .= '<li class="text-xs text-nowrap overflow-hidden text-ellipsis w-[270px]">' . $productJpa->producto . '</li>';
        }

        $name .= '</ul>';

        SaleDetail::create([
          'sale_id' => $sale->id,
          'product_image' => $offerJpa->imagen,
          'product_name' => $name,
          'product_color' => $offerJpa->color,
          'quantity' => $quantity,
          'price' => $price
        ]);
      }

      $config = [
        "amount" => round($totalCost * 100),
        "capture" => true,
        "currency_code" => "USD",
        "description" => "Compra en " . env('APP_NAME'),
        "email" => $body['culqi']['email'] ?? $body['contact']['email'],
        "installments" => 0,
        "antifraud_details" => [
          "address" => isset($request['address']['street']) ? $request['address']['street'] : 'Sin direccion',
          "address_city" => isset($request['address']['city']) ? $request['address']['city'] : 'Sin ciudad',
          "country_code" => "PE",
          "first_name" => $request['contact']['name'],
          "last_name" => $request['contact']['lastname'],
          "phone_number" => $request['contact']['phone'],
        ],
        "source_id" => $request['culqi']['id']
      ];

      $charge = $culqi->Charges->create($config);
      
      if (gettype($charge) == 'string') {
        $res = JSON::parse($charge);
        throw new Exception($res['user_message']);
      }

      $sale->status_id = 3; // Pagado
      $sale->status_message = 'La venta se ha generado y ha sido pagada';
      $sale->code = $charge?->reference_code ?? $sale->code;
      $sale->save();

      foreach ($productsJpa as $productJpa) {

        $key = array_search($productJpa->id, array_column($body['cart'], 'id'));
        $checkin = $body['cart'][$key]['checkin'];
        $checkout = $body['cart'][$key]['checkout'];

        if (!$checkin || !$checkout) {
          continue;
        }

        $calendarPath = public_path('storage/calendars/' . $productJpa->sku . '.ics');

        DB::table('events')->insert([
          'product_id' => $productJpa->id,
          'sku' => $productJpa->sku,
          'checkin' => $checkin,
          'checkout' => $checkout,
          'description' => 'Reserva realizada por ' . $sale->name . ' ' . $sale->lastname,
        ]);

        $eventos = DB::table('events')
        ->where('product_id', $productJpa->id)
        ->get();

        $calendar = Calendar::create($productJpa->producto . ' Calendar')
            ->appendProperty(TextProperty::create('PRODID', '-//' . env('APP_NAME') . '//Calendario Reservas//ES'))
            ->name($productJpa->producto . ' Calendar')
            ->description('Calendario de reservas para ' . $productJpa->producto)
            ->refreshInterval(30)
            ->appendProperty(TextProperty::create('CALSCALE', 'GREGORIAN'));
        
        foreach ($eventos as $evento) {

          $checkinDate = Carbon::parse($evento->checkin)->startOfDay();
          $checkoutDate = Carbon::parse($evento->checkout)->endOfDay();

          $event = Event::create('Reserva para ' . $productJpa->producto)
            ->startsAt($checkinDate)
            ->endsAt($checkoutDate)
            ->description($evento->description ?? 'Reserva sin descripción')
            ->fullDay();
  
          $calendar->event($event);
        }

        // Guardar el calendario actualizado
        file_put_contents($calendarPath, $calendar->get());
 
      }

      $datacorreo = [
        'nombre' => $sale->name . ' ' . $sale->lastname,
        'email' => $sale->email,
      ];

      $this->envioCorreoVenta($datacorreo);
      $this->envioCorreoAdmin();

      DB::commit();

      $response->status = 200;
      $response->message = "Cargo creado correctamente";
      $response->data = [
        'charge' => $charge,
        'reference_code' => $charge?->reference_code ?? null,
        'amount' => $totalCost
      ];

    } catch (\Throwable $th) {

      DB::rollBack();

      try {
        // Intentar guardar la venta con estado de error
        $sale->status_id = 2; // Error en pago
        $sale->status_message = 'Error en el pago: ' . $th->getMessage();
        $sale->save();
        
      } catch (\Throwable $innerTh) {
          error_log('Error al guardar venta fallida: ' . $innerTh->getMessage());
      }

      $response->status = 400;
      $response->message = $th->getMessage();

      error_log('Error en PaymentController: ' . $th->getMessage());
      error_log($th->getTraceAsString());
    }

    return response($response->toArray(), $response->status);
  }

  private function envioCorreoVenta($data)
  {
    $appUrl = env('APP_URL');
    $name = $data['nombre'];
    $mensaje = "Reserva realizada - Ventura";
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
                    ¡Reserva
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
                    En breve estaremos comunicandonos contigo.
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
                      border-radius: 32px;
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
    }
  }

  private function envioCorreoAdmin()
  {
      $emailadmin = General::first()->email;
      $appUrl = env('APP_URL');
      $name = 'Administrador';
      $mensaje = 'Tienes una nueva reserva - Ventura';
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
                                <span style="color: #002677">¡Reserva confirmada en venturabnb.pe!</span>
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
                                Tienes una reserva confirmada, para mas detalle revisar tu panel de administración.
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

  function calcularCostoPorPersonas($cantidadPersonas, $personRanges) {
      // Si no hay rangos definidos, no hay costo extra
      if (empty($personRanges)) {
          return 0;
      }
      
      // Ordenar los rangos por cantidad mínima (ascendente)
      usort($personRanges, function($a, $b) {
          return $a['min'] - $b['min'];
      });
      
      $costoExtra = 0;
      
      // Recorremos cada rango para calcular el costo
      foreach ($personRanges as $i => $range) {
          $nextRange = $personRanges[$i + 1] ?? null;
          
          // Determinar el límite superior del rango actual
          $upperLimit = $nextRange ? $nextRange['min'] - 1 : PHP_INT_MAX;
          
          // Si la cantidad de personas está dentro de este rango
          if ($cantidadPersonas >= $range['min'] && $cantidadPersonas <= $upperLimit) {
              // Calcular cuántas personas están por encima del mínimo base
              $personasExtras = max(0, $cantidadPersonas - $range['min'] + 1);
              
              // Aplicar el precio del rango a las personas extras
              $costoExtra = $personasExtras * $range['price'];
              break;
          }
      }
      
      return $costoExtra;
  }
}
