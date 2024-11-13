<footer class="bg-[#009A84]">
    <style>
        #modalPoliticasDev #modalTerminosCondiciones #modallinkPoliticasDatos {
            ;
            height: 70vh;
            /* Establece la altura del modal al 70% de la altura de la ventana gráfica */
            overflow-y: auto;
            /* Permite el desplazamiento vertical si el contenido excede la altura del modal */
        }

        #modalPoliticasDev .prose,
        #modalTerminosCondiciones .prose,
        #modallinkPoliticasDatos .prose {
            max-width: 100%;
            text-align: justify;

        }

        .prose * {
            margin-bottom: 0% !important;
            margin-top: 0% !important;
        }
    </style>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 md:justify-center w-full px-[5%] py-8 lg:py-16 ">

        <div class="flex flex-col text-white text-base justify-start items-start gap-5">
            <img class="h-20 object-contain" src="{{ asset('images/svg/venturalogo2.svg') }}" />
            <p class="font-FixelText_Light text-sm">{{ $datosgenerales->aboutus }}</p>
            <div class="mt-3">
                <a href="{{route('contacto')}}" class="text-sm font-FixelText_Semibold tracking-wide bg-[#73F7AD] border-2 border-[#73F7AD] text-[#009A84] px-3 md:px-6 py-3.5 rounded-2xl">
                    Solicitar una cita</a>
            </div>
        </div>

        <div class="flex flex-col text-sm font-FixelText_Light text-white gap-2 pl-0 md:pl-[10%]">
            <h3 class="text-xl text-white font-Homie_Bold pb-3">Enlaces</h3>
            <a href="{{route('index')}}">Inicio</a>
            <a href="{{route('nosotros')}}">Nosotros</a>
            <a href="{{route('Catalogo.jsx')}}">Propiedades</a>
            <a href="{{route('contacto')}}">Contacto</a>
        </div>

        <div class="flex flex-col text-sm font-FixelText_Light text-white gap-2">
            <h3 class="text-xl text-white font-Homie_Bold pb-3">Datos de contacto</h3>
            <p>{{ config('app.name') }}</p>
            <p>{{ $datosgenerales->address }} {{ $datosgenerales->inside }}</p>
            <p> {{ $datosgenerales->city }} - {{ $datosgenerales->country }}</p>
            <p>{{ $datosgenerales->cellphone }}</p>
            <p>{{ $datosgenerales->email }}</p>
        </div>

        <div class="flex flex-col text-sm font-FixelText_Light text-white gap-2">
            <h3 class="text-xl text-white font-Homie_Bold pb-3">Aviso legal</h3>
            <a href="/contacto">Contacto</a>
            <a id="linkTerminos">Terminos y condiciones </a>
            <a id="linkPoliticas">Politicas de devolucion </a>
            <a id="linkPoliticasDatos">Politica de Datos</a>

            <a href="{{ route('librodereclamaciones') }}"><img class="w-24"
                    src="{{ asset('images/img/reclamaciones.png') }}" /></a>
        </div>

    </div>

    <div class="bg-[#009A84] py-5 flex items-center justify-center w-11/12 mx-auto border-t">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-5 w-full">
          
          <div class="text-center">
            <p class="font-normal text-sm text-white">
              Copyright &copy; 2023 {{ config('app.name') }}. Reservados todos los derechos. Powered by <a
                href="https://www.mundoweb.pe" target="_blank" class="text-white border-b border-white"> Mundo Web
              </a>
            </p>
          </div>
    
          <div class="flex flex-row gap-4 text-[#ccc]">
            @if ($datosgenerales->facebook)
              <a href="{{ $datosgenerales->facebook }}">
                <img src="{{asset('images/svg/vt_facebook.svg')}}" />
              </a>
            @endif
            @if ($datosgenerales->instagram)
              <a href="{{ $datosgenerales->instagram }}">
                <img src="{{asset('images/svg/vt_instagram.svg')}}" />
              </a>
            @endif
            @if ($datosgenerales->linkedin)
              <a href="{{ $datosgenerales->linkedin }}">
                <img src="{{asset('images/svg/vt_linkedin.svg')}}" />
              </a>
            @endif
            @if ($datosgenerales->tiktok)
              <a href="{{ $datosgenerales->tiktok }}">
                <img src="{{asset('images/svg/vt_tiktok.svg')}}" />
              </a>
            @endif
            {{-- @if ($datosgenerales->twitter)
              <a href="{{ $datosgenerales->twitter }}">
                <img src="{{asset('images/svg/vt_facebook.svg')}}" />
              </a>
            @endif --}}
            @if ($datosgenerales->whatsapp)
              <a href="{{ $datosgenerales->whatsapp }}">
                <img src="{{asset('images/svg/vt_wsp.svg')}}" />
              </a>
            @endif
          </div>
          
        </div>
      </div>

    <div id="modalTerminosCondiciones" class="modal" style="max-width: 900px !important;width: 100% !important;  ">
        <!-- Modal body -->
        <div class="p-4 ">
            <h1 class="font-Inter_SemiBold">Terminos y condiciones</h1>
            <p class="font-Inter_Regular  prose grid grid-cols-1">{!! $terminos->content ?? '' !!}</p>
        </div>
    </div>

    <div id="modalPoliticasDev" class="modal" style="max-width: 900px !important; width: 100% !important;  ">
        <!-- Modal body -->
        <div class="p-4 ">
            <h1 class="font-Inter_SemiBold">Politicas de devolucion</h1>

            <p class="font-Inter_Regular  prose grid grid-cols-1 ">{!! $politicas->content ?? '' !!}</p>


        </div>
    </div>

    <div id="modallinkPoliticasDatos" class="modal" style="max-width: 900px !important; width: 100% !important;  ">
        <!-- Modal body -->
        <div class="p-4 ">
            <h1 class="font-Inter_SemiBold">Politicas de Datos</h1>

            <p class="font-Inter_Regular  prose grid grid-cols-1">{!! $politicaDatos->content ?? '' !!}</p>


        </div>
    </div>

</footer>


<script>
    $(document).ready(function() {


        $(document).on('click', '#linkTerminos', function() {
            $('#modalTerminosCondiciones').modal({
                show: true,
                fadeDuration: 400,

            })
        })
        $(document).on('click', '#linkPoliticas', function() {
            $('#modalPoliticasDev').modal({
                show: true,
                fadeDuration: 400,


            })
        })
        $(document).on('click', '#linkPoliticasDatos', function() {
            $('#modallinkPoliticasDatos').modal({
                show: true,
                fadeDuration: 400,


            })
        })

        function alerta(message) {
            Swal.fire({
                title: message,
                icon: "error",
            });
        }

        function validarEmail(value) {
            const regex =
                /^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/

            if (!regex.test(value)) {
                alerta("Por favor, asegúrate de ingresar una dirección de correo electrónico válida");
                return false;
            }
            return true;
        }

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#subsEmail").submit(function(e) {

            console.log('enviando subscripcion');

            e.preventDefault();

            Swal.fire({

                title: 'Realizando suscripción',
                html: `Registrando... 
          <div class="max-w-2xl mx-auto overflow-hidden flex justify-center items-center mt-4">
              <div role="status">
              <svg aria-hidden="true" class="w-8 h-8 text-blue-600 animate-spin dark:text-gray-600 " viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
              </svg>

              </div>
          </div>
          `,
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });


            if (!validarEmail($('#email').val())) {
                return;
            };
            $.ajax({
                url: '{{ route('guardarUserNewsLetter') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    Swal.close();
                    Swal.fire({
                        title: response.message,
                        icon: "success",
                    });
                    $('#subsEmail')[0].reset();
                },
                error: function(response) {
                    let message = ''

                    let isDuplicado = response.responseJSON.message.includes(
                        'Duplicate entry')
                    console.log(isDuplicado)

                    if (isDuplicado) {
                        message =
                            'El correo que ha ingresado ya existe. Utilice otra dirección de correo'
                    } else {
                        message = response.responseJSON.message
                    }
                    Swal.close();
                    Swal.fire({
                        title: message,
                        icon: "warning",
                    });
                }
            });

        })
    })
</script>
