@extends('components.public.matrix', ['pagina' => 'Pago'])

@section('css_importados')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

@stop
<style>
  .dropdown {
    height: fit-content;
    box-sizing: border-box;
    position: relative;
    border-bottom: 1.5px solid white;
    /* padding: 16px 0; */
  }
</style>


@section('content')

  <style>
    .swal2-container {
      z-index: 9999999999999;
    }
  </style>
  <main>
    <form id="paymentForm" class="font-poppins w-11/12 mx-auto my-12 flex flex-col gap-10">
      @csrf

      <x-breadcrumb>
        <x-breadcrumb.item href="/carrito">Carrito</x-breadcrumb.item>
        <x-breadcrumb.item>Pago</x-breadcrumb.item>
      </x-breadcrumb>

      <div class="flex md:gap-20 flex-col md:flex-row">
        
        <div class="flex justify-between items-start md:basis-8/12 w-full md:w-auto">
          <x-ecommerce.gateway.container completed="{{ 2 }}">
            <div class="flex flex-col gap-5 mt-4 font-FixelText_Semibold">
              <div>
                <div class="flex flex-col gap-8">

                  <input type="hidden" name="_token" value="KetUXGJHlBNXwBFdNlcg8R9ueYHpfGMUECXmlNyQ"
                    autocomplete="off">
                  <div class="flex flex-col gap-5 pb-10 border-b-2 border-gray-200 dark:border-gray-700">
                    <h2 class="font-semibold text-[20px] text-[#151515]">
                      Información del contacto
                    </h2>
                    <div class="flex flex-col gap-5">
                      <div class="flex flex-col md:flex-row gap-5">
                        <div class="basis-2/3 flex flex-col gap-2">
                          <label for="email" class="font-medium text-[13px] text-[#6C7275]">E-mail <span
                              class="text-red-500">*</span></label>
                          <input id="email" type="email" placeholder="Correo electrónico" required=""
                            name="email" value="{{ auth()->check() ? auth()->user()->email : '' }}"
                            class="w-full py-3 px-4 focus:outline-none focus:ring-[#00897b] focus:border-[#00897b] placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]"
                            required>
                        </div>
                        <div class="basis-1/3 flex flex-col gap-2">
                          <label for="celular" class="font-medium text-[13px] text-[#6C7275]">Celular <span
                              class="text-red-500">*</span></label>
                          <input id="celular" type="text" placeholder="(+51) 000 000 000" name="phone"
                            value="{{ auth()->check() ? auth()->user()->phone : '' }}"
                            class="w-full py-3 px-4 focus:outline-none focus:ring-[#00897b] focus:border-[#00897b] placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl"
                            required>
                        </div>
                      </div>
                      <div class="flex flex-col md:flex-row gap-5">
                        <div class="basis-1/2 flex flex-col gap-2">
                          <label for="nombre" class="font-medium text-[13px] text-[#6C7275]">Nombre <span
                              class="text-red-500">*</span></label>
                          <input id="nombre" type="text" placeholder="Nombre" name="nombre"
                            value="{{ auth()->check() ? auth()->user()->name : '' }}"
                            class="w-full py-3 px-4 focus:outline-none focus:ring-[#00897b] focus:border-[#00897b] placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]"
                            required>
                        </div>
                        <div class="basis-1/2 flex flex-col gap-2">
                          <label for="apellidos" class="font-medium text-[13px] text-[#6C7275]">Apellido <span
                              class="text-red-500">*</span></label>
                          <input id="apellidos" type="text" placeholder="Apellido" name="apellidos"
                            value="{{ auth()->check() ? auth()->user()->lastname : '' }}"
                            class="w-full py-3 px-4 focus:outline-none focus:ring-[#00897b] focus:border-[#00897b] placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]"
                            required>

                        </div>


                      </div>

                      <div class="basis-2/3 flex flex-row gap-2 ">
                        <input id="termsandconditions" type="checkbox" required class="border-2 rounded-sm w-5 h-5 text-[#00897b] ring-0 focus:ring-0" />
                        <label for="termsandconditions" class="font-medium text-sm text-[#6C7275]">Estoy de acuerdo con
                          los <a class="font-bold" href="{{ route('terms_condition') }}" target="_blanck">terminos y
                            condiciones</a></label>

                      </div>
                    </div>
                  </div>

                  <div class="hidden flex-col gap-5 pb-10 w-full">
                    <h2 class="font-semibold text-[20px] text-[#151515]">
                      Dirección de envío
                    </h2>
                    <ul class="grid w-full gap-6 md:grid-cols-3">
                      <li>
                        <input type="radio" name="envio" id="recoger-option" value="recoger" class="hidden peer"
                          required @if (!$hasDefaultAddress) checked @endif>
                        <label for="recoger-option"
                          class="border inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-3 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-[#00897b] hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                          <div class="block">
                            <svg class="w-6 h-6 mb-2 text-gray-800 dark:text-white" aria-hidden="true"
                              xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                              viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z">
                              </path>
                            </svg>

                            <div class="w-full text-lg font-semibold">Recojo en tienda</div>
                            <div class="w-full text-sm">Envio gratis</div>
                          </div>
                        </label>
                      </li>
                      <li>
                        <input type="radio" name="envio" id="express-option" value="express" class="hidden peer"
                          @if ($hasDefaultAddress) checked @endif>
                        <label for="express-option"
                          class="border inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-3 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-[#00897b] hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                          <div class="block">
                            <svg class="w-6 h-6 mb-2 text-gray-800 dark:text-white" aria-hidden="true"
                              xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                              viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M10 21v-9m3-4H7.5a2.5 2.5 0 1 1 0-5c1.5 0 2.875 1.25 3.875 2.5M14 21v-9m-9 0h14v8a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-8ZM4 8h16a1 1 0 0 1 1 1v3H3V9a1 1 0 0 1 1-1Zm12.155-5c-3 0-5.5 5-5.5 5h5.5a2.5 2.5 0 0 0 0-5Z">
                              </path>
                            </svg>

                            <div class="w-full text-lg font-semibold">Delivery</div>
                            <div class="w-full text-sm">Sujeto a evaluacion</div>
                          </div>
                        </label>
                      </li>
                    </ul>
                    <div id="direccionContainer" class="flex flex-col gap-5">
                      <div class="flex flex-col gap-5">
                        @if (count($addresses) > 0)
                          <div class="flex flex-col gap-5 md:flex-row">
                            <div class="basis-2/3 flex flex-col gap-2 z-[45]">
                              <label class="font-medium text-[12px] text-[#6C7275]">Tu lista de direcciones<span
                                  class="text-red-500">*</span></label>
                              <div class="w-full">
                                <div class="dropdown w-full">
                                  <select id="addresses"
                                    class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#00897b] focus:border-[#00897b] block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 select2-hidden-accessible"
                                    data-address>
                                    <option value>Agregar una nueva direccion</option>
                                    @foreach ($addresses as $address)
                                      <option value="{{ $address->id }}" data="{{ $address }}"
                                        @if ($address->isDefault) selected @endif></option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endif
                        <div data-show="new" class="flex flex-col gap-5 md:flex-row">
                          @if ($departments->count() > 0)
                            <div class="basis-1/3 flex flex-col gap-2 z-[45]">
                              <label class="font-medium text-[13px] text-[#6C7275] ">Departamento <span
                                  class="text-red-500">*</span></label>

                              <div>
                                <!-- combo -->
                                <div class="dropdown w-full">
                                  <select name="departamento_id" id="departamento_id"
                                    class="selectpicker mt-1 h-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#00897b] focus:border-[#00897b] block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 select2-hidden-accessible"
                                    data-address>
                                    <option value="" data-select2-id="select2-data-2-4o85">Seleccione un
                                      departamento</option>
                                    @foreach ($departments as $department)
                                      <option value="{{ $department->id }}">{{ $department->description }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>



                            </div>

                            <div class="basis-1/3 flex flex-col gap-2 z-[40]">
                              <label class="font-medium text-[13px] text-[#6C7275]">
                                Provincia <span class="text-red-500">*</span>
                              </label>

                              <div>
                                <!-- combo -->
                                <div class="dropdown-provincia w-full">
                                  <select name="provincia_id" id="provincia_id"
                                    class="selectpicker mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 select2-hidden-accessible"
                                    data-address>
                                    <option value="" data-select2-id="select2-data-4-gokf">Seleccione una
                                      provincia
                                    </option>

                                  </select>
                                </div>
                              </div>
                            </div>

                            <div class="basis-1/3 flex flex-col gap-2 z-[30]">
                              <label class="font-medium text-[13px] text-[#6C7275]">
                                Distrito <span class="text-red-500">*</span>
                              </label>

                              <div>
                                <!-- combo -->
                                <div class="dropdown-distrito w-full">
                                  <select name="distrito_id" id="distrito_id"
                                    class="selectpicker mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-[13px] rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 select2-hidden-accessible"
                                    data-address>
                                    <option value="" data-select2-id="select2-data-6-ihrp">Seleccione un distrito
                                    </option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          @else
                            <div><span> ** Configure los "Costos de Envio" para que pueda visualizar esta lista
                                **</span>
                            </div>
                          @endif

                        </div>

                        <div data-show="new" class="flex flex-col gap-2">
                          <label for="nombre_calle" class="font-medium text-[13px] text-[#6C7275]">Avenida / Calle /
                            Jirón <span class="text-red-500">*</span></label>

                          <input id="nombre_calle" type="text" name="dir_av_calle"
                            placeholder="Ingresa el nombre de la calle"
                            class="w-full py-3 px-4 focus:outline-none focus:ring-[#00897b] focus:border-[#00897b] placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]"
                            data-address>
                        </div>
                      </div>
                      <div>
                        <div data-show="new" class="flex flex-col md:flex-row gap-5">
                          <div class="basis-1/2 flex flex-col gap-2">
                            <label for="numero_calle" class="font-medium text-[13px] text-[#6C7275]">Número <span
                                class="text-red-500">*</span></label>
                            <input id="numero_calle" name="dir_numero" type="text"
                              placeholder="Ingresa el número de la callle"
                              class="w-full py-3 px-4 focus:outline-none focus:ring-[#00897b] focus:border-[#00897b] placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]"
                              data-address>
                          </div>

                          <div class="basis-1/2 flex flex-col gap-2">
                            <label for="direccion" class="font-medium text-[13px] text-[#6C7275]">Dpto./ Interior/
                              Piso/
                              Lote/ Bloque
                              (opcional)</label>
                            <input id="direccion" type="text" name="dir_bloq_lote"
                              placeholder="Ejem. Casa 3, Dpto 101"
                              class="w-full py-3 px-4 focus:outline-none focus:ring-[#00897b] focus:border-[#00897b] placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>



                </div>
              </div>
            </div>
          </x-ecommerce.gateway.container>
        </div>

        <div
          class="basis-4/12 flex flex-col justify-start gap-0 py-4 order-1 2md:order-2 2md:sticky font-FixelText_Semibold top-4 h-min border rounded-md">
          <h2 class="font-semibold font-Homie_Bold text-[20px] text-[#151515] px-4">
            Resumen del pedido
          </h2>
          {{-- <div class="p-4 pb-0">
            <hr>
          </div>
          <div class="p-4">
            <label for="tipo-comprobante" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de
              comprobante</label>
            <select id="tipo-comprobante" name="comprobante"
              class="selectpicker bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
              <option value="nota_venta">Nota de venta</option>
              <option value="boleta">Boleta</option>
              <option value="factura">Factura</option>
            </select>
          </div>
          <div class="p-4 grid grid-cols-4" id="ElementosFacturacion">
          </div> --}}
          <div class="p-4 py-0">
            <hr>
          </div>
          <div class="p-4">
            <div class="font-poppins flex flex-col gap-5">
              <div class="text-[#141718] hidden justify-between items-center border-b-[1px] border-[#E8ECEF] pb-5">
                <p class="font-normal text-[16px]">Envío</p>
                <p id="precioEnvio" class="font-semibold text-[16px]">Gratis</p>
              </div>

              <div class="text-[#141718] flex justify-between items-center border-b-[1px] border-[#E8ECEF] pb-5">
                <p class="font-normal text-[16px]">Subtotal</p>
                <p id="itemSubtotal" class="font-semibold text-[16px]">$ 0.00 </p>
              </div>

              <div
                class="text-[#141718] text-[20px] flex justify-between font-semibold items-center border-b-[1px] border-[#E8ECEF] pb-5">
                <p>Total</p>
                <p id="itemTotal">$ 0.00 </p>
              </div>

              <div class="text-[#151515] flex justify-center items-center -mt-3">
                <p class="font-FixelText_Semibold text-sm">Moneda de pago: $ Dólares</p>
              </div>

              <button id="btnPagar"
                class="text-white bg-[#00897b] tracking-wider w-full py-3 rounded-2xl cursor-pointer font-semibold text-lg inline-block text-center">Pagar reservación</button>
            </div>
          </div>
        </div>

      </div>
    </form>
  </main>

  <script src="https://checkout.culqi.com/js/v4"></script>
  <script>
    $('#direccionContainer').fadeOut(0)

    const hasDefaultAddress = {{ $hasDefaultAddress ? 'true' : 'false' }};
    Culqi.publicKey = "{{ $culqi_public_key }}";

    const culqi = async () => {
      try {
        const carrito = Local.get('carrito') ?? []
        if (Culqi.token) {
          const body = {
            _token: $('[name="_token"]').val(),
            cart: carrito.map((x) => ({
              id: x.id,
              checkin: x.checkin,
              checkout: x.checkout,
              quantity: x.cantidad,
              extras: x.services,
              isCombo: x.isCombo || false
            })),
            contact: {
              name: $('#nombre').val(),
              lastname: $('#apellidos').val(),
              email: $('#email').val(),
              phone: $('#celular').val(),
              doc_number: $('#DNI').val() || $('#RUC').val(),
              doc_type: $('#tipo-comprobante').val() ?? 'nota_venta',
              razon_fact: $('#razonFact').val(),
              direccion_fact: $('#direccionFact').val(),
            },
            address: null,
            saveAddress: !Boolean($('#addresses').val()),
            culqi: Culqi.token,
            tipo_comprobante: $('#tipo-comprobante').val()
          }
          if ($('[name="envio"]:checked').val() == 'express') {
            body.address = {
              id: $('#distrito_id option:selected').attr('price-id'),
              city: $('#distrito_id option:selected').text(),
              street: $('#nombre_calle').val(),
              number: $('#numero_calle').val(),
              description: $('#direccion').val()
            }
          }

          const res = await fetch("{{ route('payment.culqi') }}", {
            method: 'POST',
            headers: {
              'Content-type': 'application/json'
            },
            body: JSON.stringify(body)
          })
          const data = await res.json()
          if (!res.ok) throw new Error(data?.message ?? 'Ocurrio un error inesperado al generar el cargo')

          /* Swal.fire({
            title: `Bien!!`,
            text: `Se ha generado el cargo por S/. ${data.data.amount.toFixed(2)}`,
            icon: "success",
          }); */

          Local.delete('carrito')

          location.href = `/agradecimiento?code=${data.data.reference_code}`

        } else if (Culqi.order) { // ¡Objeto Order creado exitosamente!
          const order = Culqi.order;
          console.log('Se ha creado el objeto Order: ', order);

        } else {
          // Mostramos JSON de objeto error en consola
          console.log('Error : ', Culqi.error);
          throw new Error(Culqi.error.message);
        }
      } catch (error) {
        Swal.fire({
          title: `Error!!`,
          text: error.message,
          icon: "error",
        });
      }
    }


    $(document).on('change', '#tipo-comprobante', function() {
      console.log('cambio', $(this).val())

      let tipoComrobante = $(this).val()

      // ElementosFacturacion
      if (tipoComrobante == 'boleta') {
        $("#ElementosFacturacion").html('')
        $('#ElementosFacturacion').html(`
          <div class="col-span-2 mb-2">
            <label for="nombre" class="font-medium text-[12px] text-[#6C7275]">DNI<span class="text-red-500">*</span></label>
            <input maxlength="8" id="DNI" type="number"  placeholder="DNI" name="DNI" value="" class="w-full py-2 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" >

            
          </div>
          <div class="col-span-4 mb-2">
            <label for="nombre" class="font-medium text-[12px] text-[#6C7275]">Razon Social<span class="text-red-500">*</span></label>
            <input  id="razonFact" type="text"  placeholder="Razon Social" name="razon_fact" value="" class="w-full py-2 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" >

            
          </div>
          <div class="col-span-4 mb-2">
            <label for="nombre" class="font-medium text-[12px] text-[#6C7275]">Direccion Facturacion<span class="text-red-500">*</span></label>
            <input  id="direccionFact" type="text"  placeholder="Direccion Boleta" name="direccion_fact" value="" class="w-full py-2 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" >

            
          </div>
        `)
      } else if (tipoComrobante == 'factura') {
        $("#ElementosFacturacion").html('')
        $('#ElementosFacturacion').html(`
          <div class="col-span-2 mb-2">
            <label for="ruc" class="font-medium text-[12px] text-[#6C7275]">RUC <span class="text-red-500">*</span></label>
            <input maxlength="11" id="RUC" type="number" placeholder="RUC" name="RUC" value="" class="w-full py-2 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" >
          </div>
          <div class="col-span-4 mb-2">
            <label for="nombre" class="font-medium text-[12px] text-[#6C7275]">Razon Social<span class="text-red-500">*</span></label>
            <input  id="razonFact" type="text"  placeholder="Ingrese Razon Social" name="razon_fact" value="" class="w-full py-2 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" >

            
          </div>
          <div class="col-span-4 mb-2">
            <label for="nombre" class="font-medium text-[12px] text-[#6C7275]">Direccion Facturacion<span class="text-red-500">*</span></label>
            <input  id="direccionFact" type="text"  placeholder="Direccion Facturacion" name="direccion_fact" value="" class="w-full py-2 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" >

            
          </div>
          
        `)
      } else {
        $("#ElementosFacturacion").html('')
      }


    })

    $(document).on('keydown', '#DNI, #RUC', function(e) {
      const controlKeys = ['Backspace', 'Delete', 'Tab', 'ArrowLeft', 'ArrowRight', 'Home', 'End'];
      if (controlKeys.includes(e.key)) {
        return;
      }

      if (e.key === '.' || e.key === ',') {
        e.preventDefault();
      }
      console.log($(this.id))
      if (this.id == 'DNI' && $(this).val().length > 7) {
        e.preventDefault();
      } else if (this.id == 'RUC' && $(this).val().length > 10) {
        e.preventDefault();
      }

    });

    $('#paymentForm').on('submit', function(e) {
      e.preventDefault();

      const precioProductos = getTotalPrice()
      const precioEnvio = getCostoEnvio()


      let existeRuc = $('#RUC').length == '' ? false : true
      let ExisteDni = $('#DNI').length == '' ? false : true
      let razonFact = $('#razonFact').length == '' ? false : true
      let direccionFact = $('#direccionFact').length == '' ? false : true

      if (ExisteDni) {
        if ($('#tipo-comprobante').val() == 'boleta' && ($('#DNI').val() == '' || $('#DNI').val().length !== 8)) {
          Swal.fire({
            title: `Error!!`,
            text: 'Ingrese su DNI Completo',
            icon: "error",
          });
          return
        }

      }
      if (existeRuc) {
        if ($('#tipo-comprobante').val() == 'factura' && ($('#RUC').val() == '' || $('#RUC').val().length !== 11)) {
          Swal.fire({
            title: `Error!!`,
            text: 'Ingrese su Ruc Completo',
            icon: "error",
          });
          return
        }

      }

      if (razonFact) {
        if ($('#razonFact').val() == '') {
          Swal.fire({
            title: `Error!!`,
            text: 'Ingrese su Razon Social',
            icon: "error",
          });
          return
        }

      }
      if (direccionFact) {
        if ($('#direccionFact').val() == '') {
          Swal.fire({
            title: `Error!!`,
            text: 'Ingrese su Direccion de Facturacion',
            icon: "error",
          });
          return
        }
      }
      const paymentMethods = { // las opciones se ordenan según se configuren
        tarjeta: true,
        yape: true,
        billetera: true,
        bancaMovil: true,
        agente: true,
        cuotealo: true,
      }


      Culqi.settings({
        title: 'Ventura',
        currency: 'USD',
        amount: Math.round((precioProductos + precioEnvio) * 100),
      });
      Culqi.options({
        paymentMethods: paymentMethods,
        paymentMethodsSort: Object.keys(paymentMethods),
        style: {
          logo: `${location.origin}/images/svg/logo_boost_header.svg`,
          bannerColor: '#272727'

        }
      })
      Culqi.open();
    })

    $('[name="envio"]').on('click', () => {
      const value = $('[name="envio"]:checked').val()
      if (value == 'express') {
        $('#direccionContainer').fadeIn(125)
        if ($('#distrito_id').val()) {
          $('#distrito_id').trigger('change')
        } else {
          $('#precioEnvio').text(`Evaluando`)
        }
        $('[data-address]').prop('required', true)
        // $('#addresses').prop('required', false)
        $('#addresses').removeAttr('required');
      } else {
        $('#direccionContainer').fadeOut(125)
        $('#precioEnvio').text('Gratis')
        $('[data-address]').prop('required', false)

      }
      calcularTotal()
    })

    const provinces = @json($provinces);
    const districts = @json($districts);

    const addressTemplate = ({
      id,
      text,
      element
    }) => {
      if (!id) return text

      const data = JSON.parse(element.getAttribute('data'))
      let price = 'Gratis'
      let className = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
      if (data.price.price > 0) {
        price = `$ ${data.price.price.toFixed(2)}`
        className = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300'
      }
      return $(`<div class="relative">
        <b class="block">
          ${data.price.district.province.department.description},
          ${data.price.district.province.description},
          ${data.price.district.description}
        </b>
        ${data.street} #${data.number}
        <span class="absolute right-2 top-[50%] translate-y-[-50%] w-max block mx-auto text-xs font-medium px-2.5 py-0.5 mb-1 rounded-full ${className}">
          ${price}  
        </span>
      </div>`)
    }

    $('#addresses').select2({
      templateResult: addressTemplate,
      templateSelection: addressTemplate
    })
    $('#departamento_id').select2()
    $('#provincia_id').select2()
    $('#distrito_id').select2()

    $('.selectpicker').select2()

    $('#addresses').on('change', function() {
      const address = $(this).val()
      if (!address) {
        $('[data-show="new"]').fadeIn()
        $('#departamento_id')
          .val(null)
          .trigger('change')
        $('#nombre_calle').val(null)
        $('#numero_calle').val(null)
        $('#direccion').val(null)
        return
      }
      const data = JSON.parse($(this).find('option:selected').attr('data'))
      $('[data-show="new"]').fadeOut()
      $('#departamento_id')
        .val(data.price.district.province.department.id)
        .trigger('change')
      $('#provincia_id')
        .val(data.price.district.province.id)
        .trigger('change')
      $('#distrito_id')
        .val(data.price.district.id)
        .trigger('change')
      $('#nombre_calle').val(data.street)
      $('#numero_calle').val(data.number)
      $('#direccion').val(data.description)
    })

    $('#departamento_id').on('change', function() {
      $('#provincia_id').html('<option value>Seleccione una provincia</option>')
      $('#distrito_id').html('<option value>Seleccione un distrito</option>')
      $('#precioEnvio').text(`Evaluando`)
      provinces.filter(x => x.department_id == this.value).forEach((province) => {
        const option = $('<option>', {
          value: province.id,
          text: province.description
        })
        $('#provincia_id').append(option)
      })
      $('#provincia_id').select2()
      calcularTotal()
    })
    $(document).on('change', '#addresses', function() {
      console.log('change', $(this).val())
    })

    $('#provincia_id').on('change', function() {
      $('#distrito_id').html('<option value>Seleccione un distrito</option>')
      $('#precioEnvio').text(`Evaluando`)
      districts.filter(x => x.province_id == this.value).forEach((district) => {
        const option = $('<option>', {
          value: district.id,
          text: district.description,
          'data-price': district.price,
          'price-id': district.price_id
        })
        $('#distrito_id').append(option)
      })
      $('#distrito_id').select2()
      calcularTotal()
    })

    $('#distrito_id').on('change', function() {
      const priceStr = $('#distrito_id option:selected').attr('data-price')
      const price = Number(priceStr) || 0
      if (price == 0) {
        $('#precioEnvio').text('Gratis')
      } else {
        $('#precioEnvio').text(`$ ${price.toFixed(2)}`)
      }
      calcularTotal()
    })

    if (hasDefaultAddress) {
      $('#express-option').trigger('click')
      $('#addresses').trigger('change')
    }

    function calcularTotal() {
      const precioProductos = getTotalPrice()
      $('#itemSubtotal').text(`$ ${precioProductos.toFixed(2)}`)
      const precioEnvio = getCostoEnvio()
      const total = precioProductos + precioEnvio

      $('#itemTotal').text(`$ ${total.toFixed(2)} `)
      $('#itemsTotal').text(`$ ${total.toFixed(2)} `)
    }
    
    const getTotalPrice = () => {
      const carrito = Local.get('carrito') ?? []
      const productPrice = carrito.reduce((total, x) => {
        //let price = (Number(x.costototal) + Number(x.preciolimpieza)) * x.cantidad
        let price = Number(x.costototal) 
        //if (Number(x.descuento)) {
        //  price = Number(x.descuento) * x.cantidad
        //}
        total += price
        return total
      }, 0)
  
      return productPrice
    }

    const getCostoEnvio = () => {
      console.log('getcostoEnvio', $('[name="envio"]:checked').val());

      if ($('[name="envio"]:checked').val() == 'recoger') return 0
      const priceStr = $('#distrito_id option:selected').attr('data-price')
      const price = Number(priceStr) || 0
      return price
    }
  </script>


@section('scripts_importados')

  <script>
    const svgVisa = `<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0 0 48 48">
                    <path fill="#1565C0" d="M45,35c0,2.209-1.791,4-4,4H7c-2.209,0-4-1.791-4-4V13c0-2.209,1.791-4,4-4h34c2.209,0,4,1.791,4,4V35z"></path><path fill="#FFF" d="M15.186 19l-2.626 7.832c0 0-.667-3.313-.733-3.729-1.495-3.411-3.701-3.221-3.701-3.221L10.726 30v-.002h3.161L18.258 19H15.186zM17.689 30L20.56 30 22.296 19 19.389 19zM38.008 19h-3.021l-4.71 11h2.852l.588-1.571h3.596L37.619 30h2.613L38.008 19zM34.513 26.328l1.563-4.157.818 4.157H34.513zM26.369 22.206c0-.606.498-1.057 1.926-1.057.928 0 1.991.674 1.991.674l.466-2.309c0 0-1.358-.515-2.691-.515-3.019 0-4.576 1.444-4.576 3.272 0 3.306 3.979 2.853 3.979 4.551 0 .291-.231.964-1.888.964-1.662 0-2.759-.609-2.759-.609l-.495 2.216c0 0 1.063.606 3.117.606 2.059 0 4.915-1.54 4.915-3.752C30.354 23.586 26.369 23.394 26.369 22.206z"></path><path fill="#FFC107" d="M12.212,24.945l-0.966-4.748c0,0-0.437-1.029-1.573-1.029c-1.136,0-4.44,0-4.44,0S10.894,20.84,12.212,24.945z"></path>
                    </svg>`

    const svgMasterCar = `<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0 0 48 48">
                        <path fill="#3F51B5" d="M45,35c0,2.209-1.791,4-4,4H7c-2.209,0-4-1.791-4-4V13c0-2.209,1.791-4,4-4h34c2.209,0,4,1.791,4,4V35z"></path><path fill="#FFC107" d="M30 14A10 10 0 1 0 30 34A10 10 0 1 0 30 14Z"></path><path fill="#FF3D00" d="M22.014,30c-0.464-0.617-0.863-1.284-1.176-2h5.325c0.278-0.636,0.496-1.304,0.637-2h-6.598C20.07,25.354,20,24.686,20,24h7c0-0.686-0.07-1.354-0.201-2h-6.598c0.142-0.696,0.359-1.364,0.637-2h5.325c-0.313-0.716-0.711-1.383-1.176-2h-2.973c0.437-0.58,0.93-1.122,1.481-1.595C21.747,14.909,19.481,14,17,14c-5.523,0-10,4.477-10,10s4.477,10,10,10c3.269,0,6.162-1.575,7.986-4H22.014z"></path>
                        </svg>`

    function obtnerSvg(input) {
      const visaPattern = /^4/;
      const mastercardPattern = /^5/;
      const amexPattern = /^3/;
      const discoverPattern = /^6/;

      if (visaPattern.test(input)) {
        return svgVisa;
      } else if (mastercardPattern.test(input)) {
        return svgMasterCar;
      } else if (amexPattern.test(input)) {
        return "American Express";
      } else if (discoverPattern.test(input)) {
        return "Discover";
      } else {
        return "Tipo de tarjeta no reconocido";
      }

    }
    $('#numero_tarjeta').on('input', function() {
      let input = $('#numero_tarjeta').val()

      let svg = obtnerSvg(input)
      $('#iconoTarjeta').html(svg)


    })
  </script>

  <script>
    $('#pagarProductos').on('click', function(e) {
      console.log('pagando servicio');
      e.preventDefault()
      let formDataArray = $('#formHome').serializeArray();
      console.log(formDataArray)

      $.ajax({
        url: '{{ route('procesar.pago') }}',
        method: 'POST',
        data: $('#formHome').serialize(),
        success: function(response) {
          console.log(response)
          Swal.close();
          Swal.fire({
            title: `Exito!!`,
            text: `Informacion procesada correctamente`,
            icon: "success",
          });
          //limpiar carrito de compra
          setTimeout(function() {

            window.location.href = `/agradecimiento?codigoCompra=${response.codigoCompra}`
          }, 3000);
        },
        error: function(response) {
          console.log(response)
          const customMessages = response.responseJSON.message.validator.customMessages;
          const messages = Object.keys(customMessages).map(key => customMessages[key]);
          Swal.close();
          Swal.fire({
            title: `Opps!!`,
            text: messages,
            icon: "error",
          });
        }
      });
    })
  </script>

  {{-- <script>
    // let articulosCarrito = [];
    let checkedRadio = false


    function deleteOnCarBtn(id, operacion) {
      console.log('Elimino un elemento del cvarrio');
      const prodRepetido = articulosCarrito.map(item => {
        if (item.id === id && item.cantidad > 0) {
          item.cantidad -= Number(1);
          return item; // retorna el objeto actualizado 
        } else {
          return item; // retorna los objetos que no son duplicados 
        }

      });

      Local.set("carrito", articulosCarrito)
      limpiarHTML()
      PintarCarrito()


    }

    function addOnCarBtn(id, operacion) {

      const prodRepetido = articulosCarrito.map(item => {
        if (item.id === id) {
          item.cantidad += Number(1);
          return item; // retorna el objeto actualizado 
        } else {
          return item; // retorna los objetos que no son duplicados 
        }

      });
      Local.set("carrito", articulosCarrito)
      // localStorage.setItem('carrito', JSON.stringify(articulosCarrito));
      limpiarHTML()
      PintarCarrito()


    }

    function deleteItem(id) {
      articulosCarrito = articulosCarrito.filter(objeto => objeto.id !== id);

      Local.set("carrito", articulosCarrito)
      limpiarHTML()
      PintarCarrito()
    }

    var appUrl = <?php echo json_encode($url_env); ?>;
    $(document).ready(function() {
      articulosCarrito = Local.get('carrito') || [];

      PintarCarrito();
    });

    function limpiarHTML() {
      //forma lenta 
      /* contenedorCarrito.innerHTML=''; */
      $('#itemsCarrito').html('')
      $('#itemsCarritoPago').html('')


    }

    $('#btnAgregarCarrito').on('click', function() {
      let url = window.location.href;
      let partesURl = url.split('/')
      let item = partesURl[partesURl.length - 1]
      let cantidad = Number($('#cantidadSpan span').text())
      item = item.replace('#', '')



      // id='nodescuento'


      $.ajax({

        url: `{{ route('carrito.buscarProducto') }}`,
        method: 'POST',
        data: {
          _token: $('input[name="_token"]').val(),
          id: item,
          cantidad

        },
        success: function(success) {
          let {
            producto,
            id,
            descuento,
            precio,
            imagen,
            color
          } = success.data
          let cantidad = Number(success.cantidad)
          let detalleProducto = {
            id,
            producto,
            descuento,
            precio,
            imagen,
            cantidad,
            color,
            tipo_envio: 0

          }
          let existeArticulo = articulosCarrito.some(item => item.id === detalleProducto.id)
          if (existeArticulo) {
            //sumar al articulo actual 
            const prodRepetido = articulosCarrito.map(item => {
              if (item.id === detalleProducto.id) {
                item.cantidad += Number(detalleProducto.cantidad);
                return item; // retorna el objeto actualizado 
              } else {
                return item; // retorna los objetos que no son duplicados 
              }

            });
          } else {
            articulosCarrito = [...articulosCarrito, detalleProducto]

          }

          localStorage.setItem('carrito', JSON.stringify(articulosCarrito));

          limpiarHTML()
          PintarCarrito()

        },
        error: function(error) {
          console.log(error)
        }
      })

      // articulosCarrito = {...articulosCarrito , detalleProducto }
    })
    // $('#openCarrito').on('click', function() {
    //   $('.main').addClass('blur')
    // })
    // $('#closeCarrito').on('click', function() {
    //   $('.main').removeClass('blur')
    //   $('.cartContainer').addClass('hidden')
    //   $('#check').prop('checked', false);

    // })
  </script> --}}

@stop

@stop
