@extends('components.public.matrix', ['pagina' => 'index'])

@section('css_importados')

@stop

@php
    $bannersBottom = array_filter($banners, function ($banner) {
        return $banner['potition'] === 'bottom';
    });
    $bannerMid = array_filter($banners, function ($banner) {
        return $banner['potition'] === 'mid';
    });
@endphp

<style>
    @media (max-width: 600px) {
        .fixedWhastapp {
            right: 13px !important;
        }
    }
    .swiper-pagination-carruseltop .swiper-pagination-bullet {
        width: 14px;
        height: 8px;
        border-radius: 6px;
        background-color: #73F7AD !important;     
    }

    .swiper-pagination-carruseltop .swiper-pagination-bullet:not(.swiper-pagination-bullet-active) {
        background-color: #05304e56!important;
        opacity: 1;
    }
</style>



@section('content')

    <main>

        <section
            class="flex flex-col lg:flex-row gap-3 lg:gap-10 justify-center items-center px-[5%] lg:pl-[5%] lg:pr-0 bg-[#5BE3A4]">

            <!-- Primer div -->
            <div class="w-full lg:w-[55%] text-[#151515] flex flex-col justify-center items-center gap-2 md:gap-5">
                <div class="w-full flex flex-col gap-5 px-0 lg:pr-[5%] pt-8 lg:pt-0 xl:max-w-3xl">
                    <h1 class="text-[#F8FCFF] font-Homie_Bold text-4xl lg:text-5xl">
                        {{$textoshome->title1section ?? 'Ingrese un texto'}}
                    </h1>
                    <p class="text-[#F8FCFF] text-lg font-FixelText_Regular">
                        {{$textoshome->description1section ?? 'Ingrese un texto'}}
                    </p>
                </div>

                <div class="w-full flex flex-col gap-5 px-0 lg:pr-[5%] pt-8 md:pt-0 relative">
                    <!--  -->
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
                                    <select name="departamento_id" id="lugar"
                                        class="w-full min-w-36 py-3 text-sm border-0  font-FixelText_Medium self-stretch my-auto basis-0 bg-transparent focus:ring-0 focus:border-0 border-none selection:text-[#000929] text-[#006258] placeholder:text-opacity-30">
                                                <option class="line-clamp-1" value="">Ubicación</option>
                                            @foreach ($distritosfiltro as $ubicaciones)
                                                @if (!empty($ubicaciones->distrito_id && !empty($ubicaciones->distrito->description)))
                                                    <option class="line-clamp-1" value="{{$ubicaciones->distrito_id}}">{{$ubicaciones->distrito->description}}</option>
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
                                                   <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                        </select>
                                        
                                    </div>
                                </div>
                                </div>
                            </div>    
                

                            <div class="flex justify-center items-center w-full md:col-span-1">
                                    <div class="flex justify-start items-center">
                                        <button id="linkExplirarAlquileres"
                                            class="bg-[#009A84] rounded-xl font-FixelText_Semibold text-base text-white px-3 py-3 text-center">
                                            <span class="hidden md:flex"><i class="fa-solid fa-magnifying-glass"></i></span>
                                            <span class="flex md:hidden px-7">Buscar</span>
                                        </button>
                                    </div>
                            </div>

                        </div>
                        
                         <!-- Pequeño slogan  -->
                        <p class="font-FixelText_Regular underline text-sm text-white mt-2">
                            Propietario, anuncia tu propiedad gratis
                        </p>
                    </div>
                </div>
            </div>

            <!-- Segundo div -->
            <div class="w-full lg:w-[45%] ">
                <div class="w-full h-full -mb-20 flex flex-row items-center justify-center">
                    <img src="{{asset($textoshome->url_image1section)}}" onerror="this.src='{{ asset('images/img/portadavt.png') }}';" class="min-h-[500px] object-contain xl:h-[700px]" />
                </div>
            </div>

        </section>


        @if ($estadisticas->count() > 0)
            <section
                class="flex flex-col md:flex-row gap-10 lg:gap-20 items-center justify-center px-[5%] xl:px-[8%] py-8 lg:py-16 mt-20 lg:mt-14">

                <div class="w-full lg:w-1/2 flex flex-col items-start justify-center gap-5 xl:max-w-xl mx-auto">
                    <h2 class="text-4xl lg:text-5xl font-Homie_Bold text-[#006258]">
                        {{$textoshome->title2section ?? 'Ingrese un texto'}}
                    </h2>
                    <p class="text-lg text-[#000929] font-FixelText_Regular">
                        {{$textoshome->description2section ?? 'Ingrese un texto'}}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-5 sm:gap-10 mt-5">
                        @foreach ($estadisticas as $estadistica)
                            <div class="flex flex-col gap-2">
                                <h2 class="text-4xl lg:text-5xl font-FixelText_Bold text-[#002677]">
                                    {{ $estadistica->title }}
                                </h2>
                                <p class="text-sm text-[#009A84] font-FixelText_Medium">{{ $estadistica->description }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex flex-col sm:flex-row gap-10 mt-2">
                        <a href="{{ route('nosotros') }}"
                            class="bg-[#00897B] text-[#73F7AD] px-4 py-3 rounded-xl font-FixelText_Semibold">
                            Sobre Nosotros
                        </a>
                    </div>
                </div>

                <div class="w-full lg:w-1/2 flex flex-col items-center justify-center">
                    <img class="h-full w-full py-[5%] lg:py-[10%] object-contain"
                        src="{{asset($textoshome->url_image2section)}}" onerror="this.src='{{ asset('images/img/portada_vt4.png') }}';" />
                </div>

            </section>
        @endif

        @if ($ultimosProductos->count() > 0)
            <section class="w-full px-[5%] xl:px-[8%] pb-12 overflow-visible" style="overflow-x: visible">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center w-full gap-10">
                    <div class="flex flex-col gap-3 max-w-2xl">
                        <h1 class="text-3xl lg:text-4xl font-Homie_Bold text-[#002677]">Nuestras propiedades</h1>
                        <p class="text-lg text-[#000929] font-FixelText_Regular">Conoce acá todas las propiedades exclusivas
                            que tenemos disponibles.
                            Disfruta de una estadía perfecta en las mejores zonas de Lima.</p>
                    </div>
                    <div>
                        <a href="/catalogo"
                            class="bg-[#00897B] text-[#73F7AD] px-4 py-4 rounded-xl font-FixelText_Semibold">
                            Ver todos los departamentos</a>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 md:flex-row gap-4 lg:gap-8 mt-7 w-full">
                    @foreach ($ultimosProductos as $item)
                        <x-product.container width="col-span-1 " bgcolor="" :item="$item" />
                    @endforeach
                </div>
            </section>
        @endif

        @if ($testimonie->count() > 0)    
          <section
              class="flex flex-col md:flex-row md:gap-10 lg:gap-20 items-center justify-center px-[5%] xl:px-[8%] w-full bg-[#009A84]">

              <div class="flex flex-col w-full md:w-1/2 pt-10 lg:py-10">
                  <div class="flex flex-col w-full text-center max-w-2xl gap-5 mx-auto">
                      <h2 class="text-4xl lg:text-5xl font-Homie_Bold text-[#73F7AD]">{{$textoshome->title3section ?? 'Ingrese un texto'}}</h2>
                      <p class="text-base font-FixelText_Regular text-white px-[5%]">
                        {{$textoshome->description3section ?? 'Ingrese un texto'}}
                      </p>
                  </div>
                  <div>
                      <div class="swiper testimonios">
                          <div class="swiper-wrapper">
                              @foreach ($testimonie as $testimonios)
                                  <div class="swiper-slide cursor-pointer">
                                      <div class="flex flex-col w-full mt-5">
                                          <p class="text-xl font-FixelText_Semibold text-center text-white line-clamp-4">
                                              {{ $testimonios->testimonie }}
                                          </p>
                                      </div>

                                      <div class="flex flex-col items-center self-center mt-5 gap-5">
                                          <p class="text-base font-FixelText_Semibold text-center text-white">
                                              <span class="text-lg text-[#73F7AD]">{{ $testimonios->name }},</span>
                                              <span
                                                  class="text-lg text-white font-FixelText_Regular">{{ $testimonios->ocupation }}</span>
                                          </p>
                                          <div class="flex items-center">
                                              <img loading="lazy" src="{{ asset($testimonios->url_image) }}"
                                                  onerror="this.onerror=null;this.src='/images/img/noimagen.jpg';"
                                                  class="object-cover shrink-0 self-stretch my-auto rounded-full aspect-square w-20 h-20"
                                                  alt="{{ $testimonios->name }}" />
                                          </div>
                                      </div>
                                  </div>
                              @endforeach
                          </div>
                          <div class="swiper-pagination-carruseltop !flex justify-center py-3 mt-3"></div>
                      </div>
                  </div>

              </div>

              <div class="flex flex-col w-full md:w-1/2 justify-end items-end">
                  <img loading="lazy" class="object-cover lg:object-contain w-full md:h-[550px]"
                     src="{{asset($textoshome->url_image3section)}}" onerror="this.src='{{ asset('images/img/imagenchica.png') }}';" />
              </div>

          </section>
        @endif

        @if ($benefit->count() > 0)
            <section
                class="flex flex-col lg:flex-row md:gap-10 lg:gap-20 items-center justify-center px-[5%] xl:px-[8%] py-10 lg:py-20 w-full">

                <div class="flex overflow-hidden flex-col min-w-[240px] w-full lg:w-2/5">
                    <div class="flex relative flex-col w-full rounded-3xl overflow-hidden">

                        <img loading="lazy" class="object-cover object-bottom absolute inset-0 h-full size-full"
                            src="{{ asset('images/svg/fondoverde.svg') }}" alt="" />

                        <div
                            class="flex relative flex-col px-8 pt-4 md:pt-12 pb-80 w-full rounded-none min-h-[638px] max-md:px-5 max-md:pb-24  ">

                            <img loading="lazy"
                                class="object-cover sm:object-contain object-bottom absolute inset-0 size-full"
                                src="{{asset($textoshome->url_image4section)}}" onerror="this.src='{{ asset('images/img/chicos_vt.png') }}';" alt="" />

                            <div class="flex relative flex-col justify-center mb-0 w-full max-md:mb-2.5">
                                <div class="flex flex-col w-full gap-3">
                                    <h2 class="text-2xl md:text-3xl font-Homie_Bold text-[#73F7AD]">
                                        {{$textoshome->title4section ?? 'Ingrese un texto'}}
                                    </h2>
                                    <p class="text-base text-white font-FixelText_Light">
                                        {{$textoshome->description4section ?? 'Ingrese un texto'}}
                                    </p>
                                </div>
                                <a href="{{route('contacto')}}"
                                    class="px-4 self-end py-2.5 mt-2 text-xs font-FixelText_Semibold text-center text-[#009A84] bg-[#73F7AD] rounded-xl">
                                    Ponte en contacto
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="flex flex-col min-w-[240px] w-full lg:w-3/5  ">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 lg:gap-10 items-start w-full max-md:mt-10">
                        @foreach ($benefit as $beneficios)
                            <article class="flex flex-col flex-1 shrink basis-0 min-w-[240px]">
                                <img loading="lazy"
                                    src="{{asset('images/img/imagencasa.png')}}"
                                    class="object-contain w-14 aspect-square" alt="Icono de cuidado de propiedad" />
                                <div class="flex flex-col mt-4 w-full">
                                    <h3 class="text-2xl font-Homie_Bold tracking-tight leading-9 text-[#002677]">
                                        {{ $beneficios->titulo }}
                                    </h3>
                                    <p class="mt-2 text-base font-FixelText_Regular text-[#000929]">
                                        {{ $beneficios->descripcionshort }}
                                    </p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

            </section>
        @endif

        <section class="flex flex-col justify-center items-center px-[5%] xl:px-[8%] py-14 w-full bg-[#73F7AD]">
            <div class="flex flex-col max-w-xl">

                <div class="flex flex-col w-full text-center gap-5 text-[#006258]">
                    <h2 class="text-4xl font-Homie_Bold">{{$textoshome->title5section ?? 'Ingrese un texto'}}</h2>
                    <p class="text-base font-FixelText_Regular text-[#000929]">{{$textoshome->description5section ?? 'Ingrese un texto'}}</p>
                </div>

                <div class="flex flex-col mt-8 w-full">
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


        <section class="flex flex-col md:flex-row px-[5%] lg:px-[8%] py-8 lg:py-16">

            <div class="flex flex-col px-0 md:px-5 lg:px-10 w-full md:w-1/2 bg-white">
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

                        <input id="name" name="name" type="text"
                            class="px-4 py-3.5 text-sm font-FixelText_Regular focus:border-[#006258] focus:ring-[#006258] text-[#006258] placeholder:text-[#00625852] border border-[#00625852] rounded-xl"
                            placeholder="Nombre completo" aria-label="Nombre completo">

                        <input id="phone" name="phone" type="tel"
                            class="px-4 py-3.5 text-sm font-FixelText_Regular focus:border-[#006258] focus:ring-[#006258] text-[#006258] placeholder:text-[#00625852] border border-[#00625852] rounded-xl"
                            placeholder="Teléfono" aria-label="Teléfono">

                        <input id="emailform" name="email" type="email"
                            class="px-4 py-3.5 text-sm font-FixelText_Regular focus:border-[#006258] focus:ring-[#006258] text-[#006258] placeholder:text-[#00625852] border border-[#00625852] rounded-xl"
                            placeholder="E-mail" aria-label="E-mail">

                        <textarea id="message" name="message"
                            class="px-4 py-3.5 text-sm font-FixelText_Regular focus:border-[#006258] focus:ring-[#006258] text-[#006258] placeholder:text-[#00625852] border border-[#00625852] rounded-xl"
                            placeholder="Mensaje" aria-label="Mensaje" rows="6"></textarea>
                    </div>
                    <button type="submit"
                        class="px-4 py-3.5 mt-10 w-full text-base font-FixelText_Semibold text-emerald-300 bg-[#006258] rounded-xl ">
                        Enviar solicitud
                    </button>
                </form>
            </div>

            <div class="flex flex-col px-0 md:px-5  lg:px-10 w-full md:w-1/2">
                <div class="flex flex-col w-full">
                    <h2 class="text-3xl font-Homie_Bold text-[#002677]">{{$textoshome->title7section ?? 'Ingrese un texto'}}</h2>
                    <p class="mt-4 text-base font-FixelText_Regular text-[#000929]">
                        {{$textoshome->description7section ?? 'Ingrese un texto'}}
                    </p>
                </div>
                <div class="flex flex-col justify-center mt-10 w-full  ">
                    <div class="flex gap-2 items-start w-full  ">
                        <img loading="lazy" src="{{ asset('images/img/geo_vt.png') }}"
                            class="object-contain shrink-0 w-6 aspect-square" alt="Icono de dirección">
                        <div class="flex flex-col flex-1 shrink basis-0 min-w-[240px]">
                            <h3 class="text-lg font-FixelText_Bold text-[#002677]">Dirección</h3>
                            <p class="mt-2 text-base font-FixelText_Regular text-[#000929]">
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
                            <img loading="lazy" src="{{ asset('images/img/phone_vt.png') }}"
                                class="object-contain shrink-0 w-6 aspect-square" alt="Icono de teléfono">
                            <div class="flex flex-col flex-1 shrink basis-0 min-w-[240px]">
                                <h3 class="text-lg font-FixelText_Bold text-[#002677]">Número de Teléfono</h3>
                                <p class="mt-2 text-base font-FixelText_Regular text-[#000929]">{{ $general->cellphone }}
                                </p>
                            </div>
                        </div>
                    @endif

                    @if (!empty($general->email))
                        <div class="flex gap-2 items-start mt-8 w-full  ">
                            <img loading="lazy" src="{{ asset('images/img/mail_vt.png') }}"
                                class="object-contain shrink-0 w-6 aspect-square" alt="Icono de correo electrónico">
                            <div class="flex flex-col flex-1 shrink basis-0 min-w-[240px]">
                                <h3 class="text-lg font-FixelText_Bold text-[#002677]">Correo Electrónico</h3>
                                <p class="mt-2 text-base font-FixelText_Regular text-[#000929]">{{ $general->email }}</p>
                            </div>
                        </div>
                    @endif

                    @if (!empty($general->schedule))
                        <div class="flex gap-2 items-start mt-8 w-full  ">
                            <img loading="lazy" src="{{ asset('images/img/reloj_vt.png') }}"
                                class="object-contain shrink-0 w-6 aspect-square" alt="Icono de horario de atención">
                            <div class="flex flex-col flex-1 shrink basis-0 min-w-[240px]">
                                <h3 class="text-lg font-FixelText_Bold text-[#002677]">Horario de Atención</h3>
                                <p class="mt-2 text-base font-FixelText_Regular text-[#000929]">
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




        {{-- seccion Gran Descuento  --}}
        {{-- @if (count($bannerMid) > 0)
      <section class="flex flex-col md:flex-row justify-between bg-[#EEEEEE] mt-14 overflow-visible"
        style="overflow-x: visible">
        <x-banner-section :banner="$bannerMid" />
      </section>
    @endif --}}

        {{-- seccion Productos populares  --}}
        {{-- @if ($productosPupulares->count() > 0)
            <section class=" bg-[#F8F8F8] overflow-visible" style="overflow-x: visible">
                <div class="w-full px-[5%] py-14 lg:py-20">
                    <div class="flex flex-col md:flex-row justify-between w-full gap-3">
                        <h1 class="text-2xl md:text-3xl font-semibold font-Inter_Medium text-[#323232]">Productos
                            Destacados</h1>
                        <div class="flex  flex-col md:flex-row gap-2 md:gap-8">
              <a href="/catalogo" class="flex items-center   font-Inter_Medium  hover:text-[#006BF6] ">Todos</a>
              @foreach ($categoriasAll as $item)
                <a href="/catalogo/{{ $item->id }}"
                  class="flex items-center font-Inter_Medium  hover:text-[#006BF6]  transition ease-out duration-300 transform  ">{{ $item->name }}
                </a>
              @endforeach
            </div>
                    </div>
                    @foreach ($productosPupulares->chunk(4) as $taken)
                        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 md:flex-row gap-4 mt-14 w-full">
                            @foreach ($taken as $item)
                                <x-product.container width="w-1/4" bgcolor="bg-[#FFFFFF]" :item="$item" />
                                <x-productos-card width="w-1/4" bgcolor="bg-[#FFFFFF]" :item="$item" />
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </section>
        @endif --}}

        {{-- Seccion Blog --}}
        {{-- @if ($blogs->count() > 0)
      <section class="w-full px-[5%] py-7 lg:py-14 overflow-visible" data-aos="fade-up" style="overflow-x: visible">
        <div class="flex flex-col md:flex-row justify-between w-full gap-3">
          <h1 class="text-2xl md:text-3xl font-semibold font-Inter_Medium text-[#323232]">Blog & Eventos</h1>
          <a href="/blog/0" class="flex items-center text-base font-Inter_Medium font-semibold text-[#006BF6]">Ver todos
            las Publicaciones <img src="{{ asset('images/img/arrowBlue.png') }}" alt="Icono" class="ml-2 "></a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 mt-14 gap-10 sm:gap-5">
          @foreach ($blogs as $post)
            <x-blog.container-post :post="$post" />
          @endforeach
        </div>

      </section>
    @endif --}}


        {{-- gran descuento --}}
        {{-- @if (count($bannersBottom) > 0)
      <section class="w-full px-[5%] mt-7 lg:mt-10 ">
        <div class="bg-gradient-to-b from-gray-50 to-white flex flex-col md:flex-row justify-between bg-[#EEEEEE]">
          <x-banner-section :banner="$bannersBottom" />
        </div>
      </section>
    @endif --}}


        {{-- @if ($benefit->count() > 0)
      <section class="py-10 lg:py-13 bg-[#F8F8F8] w-full px[5%]">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 ">
          @foreach ($benefit as $item)
            <div class="flex flex-col items-center w-full gap-1 justify-center text-center px-[10%] xl:px-[18%]">
              <img src="{{ asset($item->icono) }}" alt="">
              <h4 class="text-xl font-bold font-Inter_Medium"> {{ $item->titulo }} </h4>
              <div class="text-lg leading-8 text-[#444444] font-Inter_Medium">{!! $item->descripcionshort !!}</div>
            </div>
          @endforeach
        </div>
      </section>
    @endif --}}



    </main>


    <!-- Main modal -->
    <div id="modalofertas" class="modal modalbanner">
        <!-- Modal body -->
        <div class="p-1 ">
            <x-swipper-card-ofertas :items="$popups" id="modalOfertas" />
        </div>
    </div>


@section('scripts_importados')
    <script>
        var swiper = new Swiper(".testimonios", {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            grabCursor: false,
            centeredSlides: false,
            initialSlide: 0,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination-carruseltop",
                clickable: true,
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                }
            },
            
        });
    </script>
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

            if (!validarEmail($('#emailform').val())) {
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
        let pops = @json($popups);

        function calcularTotal() {
            let articulos = Local.get('carrito')
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

            $('#itemsTotal').text(`S/. ${suma.toFixed(2)} `)

        }
        $(document).ready(function() {
            console.log(pops.length)
            if (pops.length > 0) {
                $('#modalofertas').modal({
                    show: true,
                    fadeDuration: 100
                })

            }


            $(document).ready(function() {
                articulosCarrito = Local.get('carrito') || [];

                // PintarCarrito();
            });

        })
    </script>
    <script>
         $(document).ready(function () {
            
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

       
            $('#linkExplirarAlquileres').click(function (e) {
                e.preventDefault();

                // Capturar valores de los filtros
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

                const params = new URLSearchParams();
                // Redirigir a Catalogo.jsx con parámetros
                if (lugar) {
                    params.append('lugar', lugar);
                }
                if (fechaLlegada) {
                    params.append('fecha_llegada', fechaLlegada);
                }
                if (fechaSalida) {
                    params.append('fecha_salida', fechaSalida);
                }
                if (cantidadPersonas) {
                    params.append('cantidad_personas', cantidadPersonas);
                }

                 window.location.href = `/catalogo?${params.toString()}`;
            });
        });
    </script>

@stop

@stop
