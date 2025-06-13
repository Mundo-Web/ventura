@extends('components.public.matrix', ['pagina' => 'contacto'])

@section('css_importados')

@stop

@section('content')

<main class="bg-[#FAFCFE]">
    <section class="grid grid-cols-1 text-center gap-8 items-center max-w-4xl mx-auto px-[5%] py-8 lg:py-16">
      <h2 class="text-4xl lg:text-5xl font-bold text-[#006258] px-0 lg:px-[3%] font-Homie_Bold">
        {{$textoshome->titledate9section ?? 'Ingrese un texto'}}
      </h2>
      <p class="text-lg text-[#000929] font-FixelText_Regular">
        {{$textoshome->description9section ?? 'Ingrese un texto'}}
      </p>
    </section>
      
    <section class="flex flex-col md:flex-row px-[5%] lg:px-[8%] pb-8 lg:pb-16">
      
        <div class="flex flex-col p-10 w-full md:w-1/2 bg-white shadow-lg">
          <div class="flex flex-col w-full">
            <h2 class="text-3xl font-Homie_Bold text-[#002677] ">
                {{$textoshome->title6section ?? 'Ingrese un texto'}}
            </h2>
            <p class="mt-4 text-base font-FixelText_Regular text-[#000929]">
                {{$textoshome->description6section ?? 'Ingrese un texto'}}
            </p>
          </div>
          <form id="formContactos" class="flex flex-col mt-6 w-full text-sm ">
            @csrf
            <div class="flex flex-col w-full gap-4">
              
              <input id="name" name="name" type="text" class="px-4 py-3.5 text-sm font-FixelText_Regular focus:border-[#006258] focus:ring-[#006258] text-[#006258] placeholder:text-[#00625852] border border-[#00625852] rounded-xl" placeholder="Nombre completo" aria-label="Nombre completo">
             
              <input id="phone" name="phone" type="tel" class="px-4 py-3.5 text-sm font-FixelText_Regular focus:border-[#006258] focus:ring-[#006258] text-[#006258] placeholder:text-[#00625852] border border-[#00625852] rounded-xl" placeholder="Teléfono" aria-label="Teléfono">
              
              <input id="email" name="email" type="email" class="px-4 py-3.5 text-sm font-FixelText_Regular focus:border-[#006258] focus:ring-[#006258] text-[#006258] placeholder:text-[#00625852] border border-[#00625852] rounded-xl" placeholder="E-mail" aria-label="E-mail">
             
              <textarea id="message" name="message" class="px-4 py-3.5 text-sm font-FixelText_Regular focus:border-[#006258] focus:ring-[#006258] text-[#006258] placeholder:text-[#00625852] border border-[#00625852] rounded-xl" placeholder="Mensaje" aria-label="Mensaje" rows="6"></textarea>
            </div>
            <button type="submit" class="px-4 py-3.5 mt-10 w-full font-FixelText_Medium text-emerald-300 bg-[#006258] rounded-xl ">
              Enviar solicitud
            </button>
          </form>
        </div>

        <div class="flex flex-col p-10  w-full md:w-1/2 bg-[#5BE3A5] shadow-lg">
          <div class="flex flex-col w-full">
            <h2 class="text-3xl font-Homie_Bold text-[#006258]">{{$textoshome->title7section ?? 'Ingrese un texto'}}</h2>
            <p class="mt-4 text-base font-FixelText_Regular text-[#006258]">
                {{$textoshome->description7section ?? 'Ingrese un texto'}}
            </p>
          </div>
          <div class="flex flex-col justify-center mt-10 w-full  ">

            <div class="flex gap-2 items-start w-full  ">
              <img loading="lazy" src="{{asset('images/img/ubicacion_contact.png')}}" class="object-contain shrink-0 w-6 aspect-square" alt="Icono de dirección">
              <div class="flex flex-col flex-1 shrink basis-0 min-w-[240px]">
                <h3 class="text-lg font-FixelText_Bold text-[#006258]">Dirección</h3>
                <p class="mt-2 text-base font-FixelText_Regular text-[#006258]">
                    @php
                        $locations = [];

                        if (!empty($general->address)) {
                            $locations[] = $general->address;
                        }

                        if (!empty($general->inside)) {
                            $locations[] = $general->inside;
                        }

                        if (!empty($general->district)) {
                            $locations[] = $general->district;
                        }

                        if (!empty($general->country)) {
                            $locations[] = $general->country;
                        }

                        $locationsString = implode(', ', $locations);
                    @endphp
                    {{ $locationsString }}
                </p>
              </div>
            </div>

            @if (!empty($general->cellphone))
                <div class="flex gap-2 items-start mt-8 w-full  ">
                <img loading="lazy" src="{{asset('images/img/phone_contact.png')}}" class="object-contain shrink-0 w-6 aspect-square" alt="Icono de teléfono">
                <div class="flex flex-col flex-1 shrink basis-0 min-w-[240px]">
                    <h3 class="text-lg font-FixelText_Bold text-[#006258]">Número de Teléfono</h3>
                    <p class="mt-2 text-base font-FixelText_Regular text-[#006258]">{{ $general->cellphone }}</p>
                </div>
                </div>
            @endif
            
            @if (!empty($general->email))
                <div class="flex gap-2 items-start mt-8 w-full  ">
                <img loading="lazy" src="{{asset('images/img/mail_contact.png')}}" class="object-contain shrink-0 w-6 aspect-square" alt="Icono de correo electrónico">
                <div class="flex flex-col flex-1 shrink basis-0 min-w-[240px]">
                    <h3 class="text-lg font-FixelText_Bold text-[#006258]">Correo Electrónico</h3>
                    <p class="mt-2 text-base font-FixelText_Regular text-[#006258]">{{ $general->email }}</p>
                </div>
                </div>
            @endif

            @if (!empty($general->schedule))
                <div class="flex gap-2 items-start mt-8 w-full  ">
                <img loading="lazy" src="{{asset('images/img/reloj_contact.png')}}" class="object-contain shrink-0 w-6 aspect-square" alt="Icono de horario de atención">
                <div class="flex flex-col flex-1 shrink basis-0 min-w-[240px]">
                    <h3 class="text-lg font-FixelText_Bold text-[#006258]">Horario de Atención</h3>
                    <p class="mt-2 text-base font-FixelText_Regular text-[#006258]">
                        @foreach(explode(',', $general->schedule) as $item)
                                    {{ $item }}<br>
                        @endforeach
                    </p>
                </div>
                </div>
            @endif    
          </div>
        </div>
      
    </section>
  </main>


@section('scripts_importados')
    <script>
        function alerta(message) {
            Swal.fire({
                title: message,
                icon: "error",
            });
        }

        function validarEmail(value) {
            console.log(value)
            const regex =
                /^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/

            if (!regex.test(value)) {
                alerta("El campo email no es válido");
                return false;
            }
            return true;
        }

        $('#formContactos').submit(function(event) {
            // Evita que se envíe el formulario automáticamente
            //console.log('evcnto')
            let btnEnviar = $('#btnEnviar');
            btnEnviar.prop('disabled', true);
            btnEnviar.text('Enviando...');
            btnEnviar.css('cursor', 'not-allowed');

            event.preventDefault();
            let formDataArray = $(this).serializeArray();
            
            if (!validarEmail($('#email').val())) {
                btnEnviar.prop('disabled', false);
                btnEnviar.text('Enviar Mensaje');
                btnEnviar.css('cursor', 'pointer');
                return;
            };


            /* console.log(formDataArray); */
            $.ajax({
                url: '{{ route('guardarContactos') }}',
                method: 'POST',
                data: $(this).serialize(),
                beforeSend: function() {
                    Swal.fire({
                        title: 'Enviando...',
                        text: 'Por favor, espere',
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    Swal.close(); // Close the loading message
                    $('#formContactos')[0].reset();
                    Swal.fire({
                        title: response.message,
                        icon: "success",
                    });

                    if (!window.location.href.includes('#formularioenviado')) {
                        window.location.href = window.location.href.split('#')[0] +
                        '#formularioenviado';
                    }
                    btnEnviar.prop('disabled', false);
                    btnEnviar.text('Enviar Mensaje');
                    btnEnviar.css('cursor', 'pointer');
                },
                error: function(error) {
                    Swal.close(); // Close the loading message
                    const obj = error.responseJSON.message;
                    const keys = Object.keys(error.responseJSON.message);
                    let flag = false;
                    keys.forEach(key => {
                        if (!flag) {
                            const e = obj[key][0];
                            Swal.fire({
                                title: error.message,
                                text: e,
                                icon: "error",
                            });
                            flag = true; // Marcar como mostrado
                        }
                    });
                    btnEnviar.prop('disabled', false);
                    btnEnviar.text('Enviar Mensaje');
                    btnEnviar.css('cursor', 'pointer');
                }
            });
        })
    </script>

    <script>
        $(document).ready(function() {


            function capitalizeFirstLetter(string) {
                string = string.toLowerCase()
                return string.charAt(0).toUpperCase() + string.slice(1);
            }
        })
        $('#disminuir').on('click', function() {
            console.log('disminuyendo')
            let cantidad = Number($('#cantidadSpan span').text())
            if (cantidad > 0) {
                cantidad--
                $('#cantidadSpan span').text(cantidad)
            }


        })
        // cantidadSpan
        $('#aumentar').on('click', function() {
            console.log('aumentando')
            let cantidad = Number($('#cantidadSpan span').text())
            cantidad++
            $('#cantidadSpan span').text(cantidad)

        })
    </script>
    <script>
        let articulosCarrito = [];


        function deleteOnCarBtn(id, operacion) {
            console.log('Elimino un elemento del carrito');
            console.log(id, operacion)
            const prodRepetido = articulosCarrito.map(item => {
                if (item.id === id && item.cantidad > 0) {
                    item.cantidad -= Number(1);
                    return item; // retorna el objeto actualizado 
                } else {
                    return item; // retorna los objetos que no son duplicados 
                }

            });
            Local.set('carrito', articulosCarrito)
            limpiarHTML()
            PintarCarrito()


        }

        function calcularTotal() {
            let articulos = Local.get('carrito')
            console.log(articulos)
            let total = articulos.map(item => {
                let monto
                if (Number(item.descuento) !== 0) {
                    monto = item.cantidad * Number(item.descuento)
                } else {
                    monto = item.cantidad * Number(item.precio)

                }
                return monto

            })
            const suma = total.reduce((total, elemento) => total + elemento, 0);

            $('#itemsTotal').text(`S/. ${suma} `)

        }

        function addOnCarBtn(id, operacion) {
            console.log('agrego un elemento del cvarrio');
            console.log(id, operacion)

            const prodRepetido = articulosCarrito.map(item => {
                if (item.id === id) {
                    item.cantidad += Number(1);
                    return item; // retorna el objeto actualizado 
                } else {
                    return item; // retorna los objetos que no son duplicados 
                }

            });
            console.log(articulosCarrito)
            Local.set('carrito', articulosCarrito)
            // localStorage.setItem('carrito', JSON.stringify(articulosCarrito));
            limpiarHTML()
            PintarCarrito()


        }

        function deleteItem(id) {
            console.log('borrando elemento')
            articulosCarrito = articulosCarrito.filter(objeto => objeto.id !== id);

            Local.set('carrito', articulosCarrito)
            limpiarHTML()
            PintarCarrito()
        }

        var appUrl = <?php echo json_encode($url_env); ?>;
        console.log(appUrl);
        $(document).ready(function() {
            articulosCarrito = Local.get('carrito') || [];

            PintarCarrito();
        });

        function limpiarHTML() {
            //forma lenta 
            /* contenedorCarrito.innerHTML=''; */
            $('#itemsCarrito').html('')


        }



        // function PintarCarrito() {
        //   console.log('pintando carrito ')

        //   let itemsCarrito = $('#itemsCarrito')

        //   articulosCarrito.forEach(element => {
        //     let plantilla = `<div class="flex justify-between bg-white font-Inter_Regular border-b-[1px] border-[#E8ECEF] pb-5">
    //         <div class="flex justify-center items-center gap-5">
    //           <div class="bg-[#F3F5F7] rounded-md p-4">
    //             <img src="${appUrl}/${element.imagen}" alt="producto" class="w-24" />
    //           </div>
    //           <div class="flex flex-col gap-3 py-2">
    //             <h3 class="font-semibold text-[14px] text-[#151515]">
    //               ${element.producto}
    //             </h3>
    //             <p class="font-normal text-[12px] text-[#6C7275]">

    //             </p>
    //             <div class="flex w-20 justify-center text-[#151515] border-[1px] border-[#6C7275] rounded-md">
    //               <button type="button" onClick="(deleteOnCarBtn(${element.id}, '-'))" class="  w-8 h-8 flex justify-center items-center ">
    //                 <span  class="text-[20px]">-</span>
    //               </button>
    //               <div class="w-8 h-8 flex justify-center items-center">
    //                 <span  class="font-semibold text-[12px]">${element.cantidad }</span>
    //               </div>
    //               <button type="button" onClick="(addOnCarBtn(${element.id}, '+'))" class="  w-8 h-8 flex justify-center items-center ">
    //                 <span class="text-[20px]">+</span>
    //               </button>
    //             </div>
    //           </div>
    //         </div>
    //         <div class="flex flex-col justify-start py-2 gap-5 items-center pr-2">
    //           <p class="font-semibold text-[14px] text-[#151515]">
    //             S/ ${Number(element.descuento) !== 0 ? element.descuento : element.precio}
    //           </p>
    //           <div class="flex items-center">
    //             <button type="button" onClick="(deleteItem(${element.id}))" class="  w-8 h-8 flex justify-center items-center ">
    //             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    //               <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
    //             </svg>
    //             </button>

    //           </div>
    //         </div>
    //       </div>`

        //     itemsCarrito.append(plantilla)

        //   });

        //   calcularTotal()
        // }






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
                    console.log(success)
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
                        color

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

                    Local.set('carrito', articulosCarrito)
                    let itemsCarrito = $('#itemsCarrito')
                    let ItemssubTotal = $('#ItemssubTotal')
                    let itemsTotal = $('#itemsTotal')
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
        //   console.log('abriendo carrito ');
        //   $('.main').addClass('blur')
        // })
        // $('#closeCarrito').on('click', function() {
        //   console.log('cerrando  carrito ');

        //   $('.cartContainer').addClass('hidden')
        //   $('#check').prop('checked', false);
        //   $('.main').removeClass('blur')


        // })
    </script>

    <script src="{{ asset('js/storage.extend.js') }}"></script>
@stop

@stop
