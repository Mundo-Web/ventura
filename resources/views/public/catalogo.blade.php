@extends('components.public.matrix', ['pagina' => 'catalogo'])
@section('title', 'Productos | ' . config('app.name', 'Laravel'))

@section('css_importados')


@stop


@section('content')

    <section class="flex flex-col lg:flex-row gap-3 lg:gap-10 justify-center items-center px-[5%] lg:pl-[5%] lg:pr-0 bg-[#5BE3A4]">
            
        <!-- Left Side: Text and Filters -->
        <div class="w-full lg:w-[55%] text-[#151515] flex flex-col justify-center items-center gap-2 md:gap-10">
            
            <!-- Title Section -->
            <div class="w-full flex flex-col gap-5 px-0 lg:pr-[5%] pt-8 lg:pt-0 xl:max-w-4xl">
                <h1 class="text-[#F8FCFF] font-Homie_Bold text-5xl">
                    {{ $textoshome->title1section ?? 'Propiedades que inspiran, experiencias que marcan la diferencia.' }}
                </h1>
            </div>
            
            <!-- Filter Section -->
            <div class="w-full flex flex-col gap-5 px-0 lg:pr-[5%] pt-8 md:pt-0 relative">
              <div class="px-0 w-full z-10">              
                  <!-- Tab Buttons -->
                  <div class="bg-white rounded-t-lg inline-block w-auto md:max-w-[400px]">
                      <div class="flex justify-between items-center">
                          <button
                              class="px-10 py-3 text-[#009A84] font-FixelText_Semibold border-b-[2.5px] border-[#009A84] focus:outline-none tab-button flex-1"
                              >
                              Elige unas Fechas 
                          </button>
                      </div>
                  </div>
                  
                  <!-- Tab Content -->
                  <div id="tab1" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-8 py-4 px-4 tab-content bg-white justify-between items-center gap-3 rounded-b-lg md:rounded-tr-lg w-full">
                  
                      <div class="w-full md:col-span-2">
                          <div class="relative w-full text-left">
                          <div class="group">
                              <div>
                              <select name="lugar" id="lugar"
                                  class="w-full min-w-36 py-3 text-sm border-0  font-FixelText_Medium self-stretch my-auto basis-0 bg-transparent focus:ring-0 focus:border-0 border-none selection:text-[#000929] text-[#006258] placeholder:text-opacity-30">
                                          <option class="line-clamp-1" value="">Ubicación</option>
                                        {{-- @foreach ($distritosfiltro as $ubicaciones)
                                            @if (!empty($ubicaciones->distrito_id && !empty($ubicaciones->distrito->description)))
                                              <option class="line-clamp-1" value="{{$ubicaciones->distrito_id}}" @selected($ubicaciones->distrito_id == $lugar)>{{$ubicaciones->distrito->description}}</option>
                                            @endif  
                                        @endforeach --}}
                                        @foreach ($distritosParaFiltro as $distrito_id => $productos)
                                            @php
                                                $distrito = $productos->first()->distrito; // Obtén el distrito del primer producto del grupo
                                            @endphp
                                            @if (!empty($distrito->description))
                                                <option class="line-clamp-1" value="{{$distrito_id}}">{{$distrito->description}}</option>
                                            @endif  
                                        @endforeach
                              </select>
                              </div>
                          </div>
                          </div>
                      </div>

                      <div class="w-full md:col-span-3">
                          <div class="relative w-full text-left md:text-center">
                          <div class="group">
                              <div>
                                  <input type="text" id="arrival-date" class="text-left md:text-center w-full py-3 text-sm flex-1 shrink font-FixelText_Medium self-stretch my-auto basis-0 bg-transparent focus:ring-0 focus:border-0 border-none selection:text-[#000929] text-[#006258] placeholder:text-opacity-30" value="2024-07-13" aria-label="Fecha de llegada" />
                              </div>
                          </div>
                          </div>
                      </div>


                      <div class="w-full md:col-span-2">
                          <div class="relative w-full text-left">
                          <div class="group">
                              <div>
                                  
                                    <select name="cantidad_personas" id="cantidad_personas" class="w-full text-sm font-FixelText_Medium self-stretch my-auto basis-0 bg-transparent focus:ring-0 focus:border-0 border-none selection:text-[#000929] text-[#006258] placeholder:text-opacity-30">
                                              <option value=""># Personas</option>
                                              @for ($i = 1; $i <= $limite; $i++)
                                                  <option value="{{ $i }}"
                                                  @selected($i == $cantidad)
                                                  >{{ $i }}</option>
                                              @endfor
                                    </select>
                                 
                              </div>
                          </div>
                          </div>
                      </div>    
          

                      <div class="flex justify-center items-center w-full md:col-span-1">
                              <div class="flex justify-start items-center">
                                  <a id="linkExplirarAlquileres"
                                      class="bg-[#009A84] rounded-xl font-FixelText_Semibold text-base text-white px-3 py-3 text-center">
                                      <span class="hidden md:flex"><i class="fa-solid fa-magnifying-glass"></i></span>
                                      <span class="flex md:hidden px-7">Buscar</span>
                                  </a>
                              </div>
                      </div>

                  </div>
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <!-- Pequeño slogan  -->
                  <p class="font-FixelText_Regular underline text-sm text-white mt-2">
                      Propietario, anuncia tu propiedad gratis
                  </p>
              </div>
            </div>   
        </div>

        <!-- Right Side: Image -->
        <div class="w-full lg:w-[45%]">
            <div class="w-full h-full flex flex-row items-center justify-center">
                <img src="{{ asset('images/img/portadacatalogo.png'); }}" class="h-[200px] lg:min-h-[400px] object-contain xl:h-full object-bottom" alt="Portada Catálogo" />
            </div>
        </div>

    </section>


    <section id="productosf" class="grid grid-cols-2 md:grid-cols-3 gap-4 lg:gap-8 px-[5%] pt-10 lg:pt-16">
       @foreach ($products as $item)
        <div class="flex flex-col relative w-full bg-white" data-aos="zoom-in-left">
            <!-- Contenedor del Producto -->
            <div class="bg-white product_container basis-4/5 flex flex-col justify-center relative border">
        
                <!-- Imagen del Producto -->
                <div>
                    <a href="{{ url('/producto/' . $item['id']) }}">
                        <div class="relative flex justify-center items-center h-max">
                            <img 
                                style="opacity: {{ (!$item['imagen_ambiente'] || !$showAmbiente) ? '1' : '0' }};
                                    scale: {{ (!$item['imagen_ambiente'] || !$showAmbiente) ? '1.05' : '1' }};
                                    background-color: #eeeeee;"
                                src="{{ $item['imagen'] ? asset($item['imagen']) : asset('images/img/noimagen.jpg') }}"
                                alt="{{ $item['name'] }}"
                                onerror="this.src='{{ asset('images/img/noimagen.jpg') }}';"
                                class="transition ease-out duration-300 transform w-full aspect-square object-cover inset-0" />
            
                            @if (!empty($item['imagen_ambiente']))
                                <img 
                                    style="opacity: {{ $showAmbiente ? '1' : '0' }};
                                        scale: {{ $showAmbiente ? '1.05' : '1' }};"
                                    src="{{ asset($item['imagen_ambiente']) }}"
                                    alt="{{ $item['name'] }}"
                                    onerror="this.src='{{ asset('images/img/noimagen.jpg') }}';"
                                    class="transition ease-out duration-300 transform w-full h-full aspect-square object-cover absolute inset-0" />
                            @endif
                        </div>
                    </a>
                </div>
            </div>
        
            <!-- Detalles del Producto -->
            <a href="{{ url('/producto/' . $item['id']) }}" class="px-1 py-2 flex flex-col gap-3">
                <h2 
                    class="block text-lg text-left overflow-hidden font-Homie_Bold text-[#002677]" 
                    style="display: -webkit-box; -webkit-line-clamp: 2; text-overflow: ellipsis; -webkit-box-orient: vertical; height: 51px;">
                    {{ $item['producto'] }}
                </h2>
                {{-- <p 
                    class="block text-[13px] lg:text-base text-left overflow-hidden font-FixelText_Light text-[#000929]" 
                    style="display: -webkit-box; -webkit-line-clamp: 2; text-overflow: ellipsis; -webkit-box-orient: vertical; height: 42px;">
                    {{ $item['extract'] }}
                </p> --}}
            </a>
        </div>
       @endforeach
    </section>




    <section class="flex flex-col justify-center items-center px-[5%] xl:px-[8%] py-14 w-full bg-[#73F7AD]">
      <div class="flex flex-col max-w-xl">

          <div class="flex flex-col w-full text-center gap-5 text-[#006258]">
              <h2 class="text-4xl font-Homie_Bold">{{$textoshome->title5section ?? 'Ingrese un texto'}}</h2>
              <p class="text-base font-FixelText_Regular text-[#000929]">{{$textoshome->description5section ?? 'Ingrese un texto'}}</p>
          </div>

          <div class="flex flex-col mt-8 w-full gap-4">
              <div class="flex flex-col w-full rounded-lg">
                  <form id="subsEmail"
                      class="flex flex-row gap-5 justify-end px-5 py-3.5 w-full bg-white rounded-2xl">
                      @csrf
                      <input placeholder="Introduce tu correo electrónico" type="email" id="email"
                          name="email"
                          class="w-full px-4 py-2 text-sm font-FixelText_Regular focus:border-0 focus:ring-0 text-[#006258] placeholder:text-[#00625852] border border-transparent rounded-xl"
                          aria-label="Introduce tu correo electrónico" required>
                      <input type="hidden" name="tipo" value="Inicio" />
                      <button type="submit"
                          class="self-end px-10 py-3 text-base font-FixelText_Semibold text-center text-[#73F7AD] bg-[#009A84] rounded-lg">Enviar</button>
                  </form>
              </div>
              <p class="text-base text-center font-FixelText_Regular text-[#000929]">
                  {{$textoshome->footer5section ?? 'Ingrese un texto'}}
              </p>
          </div>

      </div>
    </section>





@section('scripts_importados')


  <script src="{{ asset('js/storage.extend.js') }}"></script>

  <script>
    $(document).ready(function () {
        // Supongamos que tienes las fechas de llegada y salida como variables, por ejemplo, de PHP o JavaScript
        var llegada = '{{ old('fecha_llegada', $llegada ?? '') }}'; // Ejemplo en Laravel con valores pasados
        var salida = '{{ old('fecha_salida', $salida ?? '') }}';
        
        // Si las fechas están disponibles, inicializamos el daterangepicker
        if (llegada && salida) {
            $('#arrival-date').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY',
                    cancelLabel: 'Cancelar',
                    applyLabel: 'Aplicar'
                },
                startDate: moment(llegada, 'DD/MM/YYYY'), // Fecha de llegada
                endDate: moment(salida, 'DD/MM/YYYY'),   // Fecha de salida
                minDate: moment(),
                maxDate: moment().add(9, 'months'),
            });
        } else {
            // Si no hay fechas de llegada y salida, usa la fecha predeterminada
            $('#arrival-date').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY',
                    cancelLabel: 'Cancelar',
                    applyLabel: 'Aplicar'
                },
                startDate: moment(),
                endDate: moment(),
                minDate: moment(),
                maxDate: moment().add(9, 'months'),
            });
        }
    });
</script>

<script>
  $(document).ready(function () {
      // Cuando el usuario hace clic en el botón de búsqueda
      $('#linkExplirarAlquileres').on('click', function (e) {
            e.preventDefault();  // Prevenir el comportamiento por defecto del botón

            const lugar = $('#lugar').val();
            const rangoFechas = $('#arrival-date').val();
            const cantidadPersonas = $('#cantidad_personas').val();

            let fechaLlegada = '';
            let fechaSalida = '';

            if (rangoFechas.includes(" - ")) {
                [fechaLlegada, fechaSalida] = rangoFechas.split(" - ");
            }
                
            // Validación (opcional)
            if (!lugar && !rangoFechas && !cantidadPersonas) {
                alert("Por favor, selecciona al menos un filtro para realizar la búsqueda.");
                 return;
            }     

            // Realizar la solicitud AJAX
            $.ajax({
                url: "{{ route('filtrardepartamentos') }}",  
                dataType: "json",
                method:'GET',
                data: {
                    _token: $('input[name="_token"]').val(),
                    lugar: lugar,  // Enviar el valor de lugar
                    cantidad_personas: cantidadPersonas,  // Enviar el valor de cantidad_personas
                    llegada: fechaLlegada,
                    salida: fechaSalida
                },
                success: function (response) {
                  
                  if (response.length === 0) {
                    $('#productosf').html('<p>No se encontraron departamentos que coincidan con los filtros.</p>');
                    return;
                  }

                  let htmlContent = '';
                  const noImageUrl = '/images/img/noimagen.jpg';
                    // Iteramos sobre los departamentos recibidos
                    response.data.forEach(function(item) {
                        htmlContent += `
                        <div class="flex flex-col relative w-full bg-white" data-aos="zoom-in-left">
                            <div class="bg-white product_container basis-4/5 flex flex-col justify-center relative border">
                                <div>
                                    <div class="relative flex justify-center items-center h-max">
                                        <img 
                                            src="${item.imagen ? item.imagen : 'images/img/noimagen.jpg'}"
                                            alt="${item.producto}"
                                            onerror="this.src='${noImageUrl}';"
                                            class="transition ease-out duration-300 transform w-full aspect-square object-cover inset-0"
                                        />
                                    </div>
                                </div>
                            </div>
                            
                            <a href="/producto/${item.id}" class="px-1 py-2 flex flex-col gap-3">
                                <h2 class="block text-lg text-left overflow-hidden font-Homie_Bold text-[#002677]" 
                                    style="display: -webkit-box; -webkit-line-clamp: 2; text-overflow: ellipsis; -webkit-box-orient: vertical; height: 51px;">
                                    ${item.producto}
                                </h2>
                            </a>
                        </div>`;
                    });

                    // Agregamos el contenido generado al contenedor
                    $('#productosf').html(htmlContent);
                },
                error: function (xhr, status, error) {
                  Swal.fire({
                      title: 'Hubo un error al realizar la búsqueda',
                      text: error,
                      icon: 'warning',
                  }); 
                }
            });
      });
  });
</script>
@stop

@stop
