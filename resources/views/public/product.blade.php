@extends('components.public.matrix', ['pagina' => 'catalogo'])

@section('title', 'Producto Detalle | ' . config('app.name', 'Laravel'))
@section('meta_title', $meta_title)
@section('meta_description', $meta_description)
@section('meta_keywords', $meta_keywords)

@section('css_importados')
@stop

@section('content')

  <style>
    /* imagen de fondo transparente para calcar el dise;o */
    .clase_table {
      border-collapse: separate;
      border-spacing: 10;
    }

    .fixedWhastapp {
      right: 2vw !important;
    }

    .clase_table td {
      /* border: 1px solid black; */
      border-radius: 10px;
      -moz-border-radius: 10px;
      padding: 10px;
    }

    .swiper-pagination-bullet-active {
      background-color: #272727;
    }

    .swiper-pagination-bullet:not(.swiper-pagination-bullet-active) {
      background-color: #979693 !important;
    }

    .blocker {
      z-index: 20;
    }

    .close-modal{
      z-index: 9999;
    }
    
    @media (min-width: 600px) {
      #offers .swiper-slide {
        margin-right: 100px !important;
      }

      #offers .swiper-slide::before {
        content: '+';
        display: block;
        position: absolute;
        top: 50%;
        right: -70px;
        transform: translateY(-50%);
        font-size: 32px;
        font-weight: bolder;
        color: #ffffff;
        padding: 0px 12px;
        background-color: #0d2e5e;
        border-radius: 50%;
        box-shadow: 0 0 5px rgba(0, 0, 0, .125);
      }

      #offers .swiper-slide:last-child::before {
        content: none;
      }

    }

  </style>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <style>
    
    .date-input-container {
        display: flex;
        align-items: center;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        padding: 0.5rem;
    }
    
    .date-input {
        flex: 1;
        border: none;
        outline: none;
        padding: 0.25rem 0.5rem;
    }
    
    .selected-range {
        margin-top: 1rem;
        padding: 0.75rem;
        background-color: #f7fafc;
        border-radius: 0.375rem;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.375rem;
        padding: 0.5rem 1rem;
        font-weight: 500;
        cursor: pointer;
    }
    
    /* Flatpickr custom styles */
    .check-in-date:not(.check-in-out-date) {
        /* background: linear-gradient(to right, white 50%, #e2e8f0 50%) !important;
        border-radius: 0 !important; */
        background: linear-gradient(to right, transparent 50%, #E2E8F0 50%) !important;
        color: #adb5bd !important;
        cursor: not-allowed;
        position: relative;
    }
    
    .check-out-date:not(.check-in-out-date) {
        /* background: linear-gradient(to right, #e2e8f0 50%, white 50%) !important;
        border-radius: 0 !important; */
        background: linear-gradient(to left, transparent 50%, #E2E8F0 50%) !important;
        color: #adb5bd !important;
        cursor: not-allowed;
        position: relative;
    }
    
    .check-in-out-date {
        /* background: #e2e8f0 !important;
        border-radius: 0 !important; */
        background: #f8f9fa !important;
        color: #adb5bd !important;
        cursor: not-allowed;
    }
    
    .flatpickr-day.selected.startRange {
        border-radius: 50% 0 0 50% !important;
    }
    
    .flatpickr-day.selected.endRange {
        border-radius: 0 50% 50% 0 !important;
    }

    .blocked-date {
        background-color: #e2e8f0 !important;
        border-radius: 0 !important;
        color: #64748b !important;
        cursor: not-allowed !important;
    }

    .flatpickr-disabled{
        background: #e2e8f0 !important;
        border-radius: 100%!important;
        color: #64748b !important;
    }

    .flatpickr-day:hover{
        background-color: #e2e8f0 !important;
        color: #64748b !important;
    }

  </style>

  @php
    $images = ['', '_ambiente'];
    $x = $product->toArray();
    $i = 1;
  @endphp
  @php
    $breadcrumbs = [['title' => 'Inicio', 'url' => route('index')], ['title' => 'Producto', 'url' => '']];
  @endphp
  @php
    $StockActual = $product->stock;
    $maxStock = 100; // maximo stock

    if (!is_null($product->max_stock) > 0) {
        $maxStock = $product->max_stock;
    }
    # calculamos en % cuanto queda en base a 100
    $stock = 0;
    if ($maxStock !== 0) {
        $stock = ($StockActual * 100) / $maxStock;
    }

  @endphp
  {{-- @component('components.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
  @endcomponent --}}

  <main class="font-Inter_Regular" id="mainSection">
        @csrf
        {{-- <section class="w-full px-[5%] ">
            <div class="grid grid-cols-1 2md:grid-cols-2 gap-10 md:gap-16 pt-8 lg:pt-16">

                <div class="flex flex-col justify-start items-center gap-5">
                    <div id="containerProductosdetail"
                        class="w-full flex justify-center items-center h-[330px] 2xs:h-[400px] sm:h-[450px] xl:h-[550px] rounded-3xl overflow-hidden">
                        <img src="{{ asset($product->imagen) }}" alt="computer" class="w-full h-full object-contain"
                            data-aos="fade-up" data-aos-offset="150"
                            onerror="this.onerror=null;this.src='/images/img/noimagen.jpg';">
                    </div>
                    <x-product-slider :product="$product" />
                </div>

                <div class="flex flex-col gap-6  mt-2">
                    @foreach ($atributos as $item)
                     @foreach ($valorAtributo as $value)
                            @if ($value->attribute_id == $item->id)
                              
                                  @isset($valoresdeatributo)
                                      @foreach($valoresdeatributo as $valorat)
                                        @if($valorat->attribute_value_id == $value->id)
                                          <img src={{asset($value->imagen)}} class="w-24 h-12 object-contain"/>
                                        @endif
                                      @endforeach
                                  @endisset
                              
                            @endif
                      @endforeach
                    @endforeach
                    <div class="flex flex-col">
                        <h3 class="font-Helvetica_Medium text-4xl text-[#111111] font-normal tracking-tight">
                            {{ $product->producto }}</h3>
              
                    </div>

                    <div class="flex flex-col gap-3">
                    
                        <div class="flex flex-row gap-3 content-center items-center">
                            @if ($product->descuento == 0)
                                <div class="content-center flex flex-row gap-2 items-center">
                                    <span class="font-Helvetica_Bold text-3xl gap-2 text-[#FD1F4A]">S/
                                        {{ $product->precio }}</span>
                                </div>
                            @else
                                <div class="content-center flex flex-row gap-2 items-center">
                                    <span class="font-Helvetica_Bold text-3xl gap-2 text-[#FD1F4A]">S/
                                        {{ $product->descuento }}</span>
                                    <span class="text-[#111111] font-Helvetica_Medium line-through text-lg">S/
                                        {{ $product->precio }}</span>
                                </div>
                                @php
                                    $descuento = round(
                                        (($product->precio - $product->descuento) * 100) / $product->precio,
                                    );
                                @endphp
                                <span
                                    class="ml-2 font-Helvetica_Medium text-center content-center text-sm gap-2 bg-[#FD1F4A] text-white h-9 w-16 rounded-3xl px-2">
                                    -{{ $descuento }}% </span>
                            @endif
                        </div>
                        
                        <div class="font-medium text-base font-Helvetica_Light w-full mt-4 text-[#444]">
                            {!! $product->description !!}
                        </div>

                        @if ($product->sku)
                            <p class="font-Helvetica_Light text-base gap-2 text-[#444] mt-2">SKU: {{ $product->sku }}
                            </p>
                        @endif
                    </div>
                    
                     @if ($otherProducts->isNotEmpty())
                        <p class="mb-2 "><b>Característica</b>:
                        <span class="block bg-[#F5F5F7] p-3 mt-2" tippy> {{ $product->color }}</span>
                        
                        <p class="-mb-4 "><b>Otras opciones</b>:</p>
                                
                            <div class="flex flex-wrap gap-2">
                                @foreach ($otherProducts as $x)
                                <a class="block bg-[#F5F5F7] hover:bg-[#ebebf2] p-3" href="/producto/{{ $x->id }}" tippy> {{ $x->color }}</a>
                                @endforeach
                            </div>

                    @endif

                    @if (!$especificaciones->isEmpty())
                        <p class="font-Inter_Medium text-base gap-2 ">Especificaciones: </p>
                        <div class="min-w-full divide-y divide-gray-200">
                            <table class=" divide-y divide-gray-200 ">
                                <tbody>
                                    @foreach ($especificaciones as $item)
                                        <tr>
                                            <td class="px-4 py-1 border border-gray-200">
                                                {{ $item->tittle }}
                                            </td>
                                            <td class="px-4 py-1 border border-gray-200">
                                                {{ $item->specifications }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col xl:flex-row gap-5 items-center">
                            <div class="flex">
                                <div
                                    class="flex justify-center items-center bg-[#F5F5F5] cursor-pointer rounded-l-3xl">
                                    <button class="py-2.5 px-5 text-lg font-Helvetica_Bold rounded-full bg-black m-1 text-white" id=disminuir
                                        type="button">-</button>
                                </div>
                                <div id=cantidadSpan
                                    class="py-2.5 px-5 flex justify-center items-center bg-[#F5F5F5] text-lg font-Helvetica_Bold">
                                    <span>1</span>
                                </div>
                                <div
                                    class="flex justify-center items-center bg-[#F5F5F5] cursor-pointer rounded-r-3xl">
                                    <button class="py-2.5 px-5 text-lg font-Helvetica_Bold rounded-full bg-black m-1 text-white" id=aumentar
                                        type="button">+</button>
                                </div>
                            </div>
                            <div class="xl:ml-8 flex flex-row gap-5 justify-start items-center w-full">
                                @if ($product->status == 1 && $product->visible == 1)
                                  <button id="btnAgregarCarritoPr" data-id="{{ $product->id }}"
                                      class="bg-[#FD1F4A] w-full py-3  text-white text-center rounded-full font-Helvetica_Medium tracking-wide text-lg hover:bg-[#e61e45]">
                                      Agregar
                                      al Carrito
                                  </button>
                                @endif
                            </div>
                        </div>
                    </div>
                 

                    <div class="flex flex-col gap-2" data-aos="fade-up">
                         <div class="flex flex-row gap-5 justify-start items-center w-full">
                                <a
                                    class="bg-[#25D366] flex justify-center items-center w-full py-3  text-white text-center rounded-full font-Helvetica_Medium tracking-wide text-lg hover:bg-[#1fcf61]">
                                    <span class="text-sm mr-3">Agente Emilio</span>Consulta vía WhatsApp
                                </a>
                          </div>
                          <div class="flex flex-row gap-5 justify-start items-center w-full">
                                <a
                                    class="bg-[#25D366] flex justify-center items-center w-full py-3  text-white text-center rounded-full font-Helvetica_Medium tracking-wide text-lg hover:bg-[#1fcf61]">
                                    <span class="text-sm mr-3">Agente Emilio</span>Consulta vía WhatsApp
                                </a>
                          </div>
                    </div>
                </div>
            </div>
        </section> --}}

        <section class="flex flex-row gap-1 lg:gap-3 w-full px-[5%] mt-8 lg:mt-14 relative" aria-label="Image Gallery">
          
          <div class="w-1/3 galeriatotal ">
            @if ($product->imagen_2)
              <img id="collage1_previewer" loading="lazy" src="{{ asset($product->imagen_2) }}" class="cursor-pointer object-cover w-full rounded-xl aspect-[0.7]" alt="Gallery image 1" />
            @else
              <img id="collage1_previewer"
                    src="{{ asset('images/img/noimagen.jpg') }}" alt="imagen_alternativa"
                    class="object-cover w-full rounded-xl aspect-[0.7]" />
            @endif
          </div>
          
          <div class="flex flex-col  w-1/3 gap-1 lg:gap-3 galeriatotal ">
            @if ($product->imagen_3)
              <img id="collage2_previewer" loading="lazy" src="{{ asset($product->imagen_3) }}" class="cursor-pointer object-cover flex-1 w-full rounded-xl aspect-[1.45]" alt="Gallery image 2" />
            @else
              <img id="collage2_previewer"
                src="{{ asset('images/img/noimagen.jpg') }}" alt="imagen_alternativa"
                class="object-cover flex-1 w-full rounded-xl aspect-[1.45]" />
            @endif

            @if($product->imagen_4)
              <img id="collage3_previewer" loading="lazy" src="{{ asset($product->imagen_4) }}" class="cursor-pointer object-cover flex-1 w-full rounded-xl aspect-[1.45]" alt="Gallery image 3" />
            @else
                <img id="collage3_previewer"
                    src="{{ asset('images/img/noimagen.jpg') }}" alt="imagen_alternativa"
                    class="object-cover flex-1 w-full rounded-xl aspect-[1.45]" />
            @endif
          </div>

          <div class="w-1/3 galeriatotal">
            @if($product->image_texture)
              <img id="collage4_previewer" loading="lazy" src="{{ asset($product->image_texture) }}" class="cursor-pointer object-cover w-full rounded-xl aspect-[0.7]" alt="Gallery image 4" />
            @else
                <img id="collage4_previewer"
                src="{{ asset('images/img/noimagen.jpg') }}" alt="imagen_alternativa"
                class="object-cover w-full rounded-xl aspect-[0.7]" />
            @endif
          </div>
        </section>

        <section class="galeriatotal flex flex-row justify-start w-full px-[5%] mt-5 relative"><div><a class="bg-[#006258] text-white px-6 py-3 md:py-4 rounded-3xl text-sm font-FixelText_Semibold">Ver todas las imágenes</a></div></section>

        <section class="flex flex-col lg:flex-row gap-10 justify-between items-start px-[5%] mt-8 lg:mt-16">
          
          <div class="flex flex-col min-w-[240px] w-full max-w-4xl order-2 lg:order-1">

            <div class="flex flex-col justify-center bg-white rounded-2xl">
              <div class="flex flex-col w-full">

                <nav class="flex flex-wrap gap-10 justify-between items-start w-full text-base whitespace-nowrap min-h-[24px]">
                  <ul class="flex overflow-hidden items-center list-none gap-1 font-FixelText_Regular">
                    <li class="self-stretch my-auto text-slate-950 text-opacity-30">Inicio</li>
                    <li class="overflow-hidden self-stretch px-2 my-auto text-slate-950 text-opacity-20">/</li>
                    <li class="self-stretch my-auto text-[#002677]">Departamento</li>
                  </ul>
                  <button onclick="copiarEnlace()" class="flex items-center justify-center">
                    <img loading="lazy" src="{{ asset('images/svg/compartir.svg') }}" 
                         class="object-contain shrink-0 w-6 aspect-square" alt="Copiar enlace" />
                  </button>
                </nav>

                <article class="flex flex-col items-start mt-5 w-full">
                  <header class="flex flex-col">
                    <h1 class="text-3xl font-Homie_Bold text-[#006258]">{{ $product->producto }}</h1>
                    
                    <p class="mt-2.5 text-base font-FixelText_Regular text-slate-950 text-opacity-50">{{$product->address}}, {{$product->inside}}</p>
                    <p class="mt-2.5 text-base font-FixelText_Regular text-slate-950 text-opacity-50">
                      @php
                          $locations = [];

                          if (!empty($departamento->description)) {
                              $locations[] = $departamento->description;
                          }

                          if (!empty($provincia->description)) {
                              $locations[] = $provincia->description;
                          }

                          if (!empty($distrito->description)) {
                              $locations[] = $distrito->description;
                          }

                          $locationsString = implode(', ', $locations);
                      @endphp
                        {{ $locationsString }}
                      </p>
                  </header>
                  @if ($product->latitud && $product->longitud)
                        <div class="h-[350px] w-full" id="map"></div>
                  @endif
                  @if ($product->sku)
                  <div class="flex items-center px-3 py-1.5 mt-5 text-sm text-[#002677] border border-[#002677] border-solid bg-[#002677] bg-opacity-10 rounded-[43px]">
                    <span class="font-FixelText_Regular"># Cod. inmueble  {{ $product->sku }}</span>
                  </div>
                  @endif
                </article>

              </div>
            </div>

            <div class="flex flex-col justify-center p-8 text-xs font-medium text-center bg-white rounded-2xl  text-slate-950 max-md:px-5" aria-label="Property Features">
              <div class="flex flex-wrap gap-4 justify-between items-start w-full font-FixelText_Medium">
                @if(!empty($product->area))
                  <div class="flex flex-col items-center min-h-[50px] w-[60px]">
                    <img loading="lazy" src="{{asset('images/svg/area.svg')}}" class="object-contain w-6 aspect-square" alt="Area icon" />
                    <p class="mt-1.5">{{$product->area}} m²</p>
                  </div>
                @endif

                @if(!empty($product->cuartos))  
                <div class="flex flex-col items-center min-h-[50px] w-[60px]">
                  <img loading="lazy" src="{{asset('images/svg/cuartos.svg')}}" class="object-contain w-6 aspect-square" alt="Bedroom icon" />
                  <p class="mt-1.5">{{$product->cuartos}} cuartos</p>
                </div>
                @endif

                @if(!empty($product->banios))  
                <div class="flex flex-col min-h-[50px] w-[60px]">
                  <img loading="lazy" src="{{asset('images/svg/banios.svg')}}" class="object-contain self-center w-6 aspect-square" alt="Bathroom icon" />
                  <p class="mt-1.5">{{$product->banios}} baños</p>
                </div>
                @endif

                @if(!empty($product->cochera))  
                <div class="flex flex-col items-center min-h-[50px] w-[60px]">
                  <img loading="lazy" src="{{asset('images/svg/cochera.svg')}}" class="object-contain w-6 aspect-square" alt="Parking space icon" />
                  <p class="mt-1.5">{{$product->cochera}} espacios</p>
                </div>
                @endif

                @if(!empty($product->pisos))  
                <div class="flex flex-col items-center min-h-[50px] w-[60px]">
                  <img loading="lazy" src="{{asset('images/svg/piso.svg')}}" class="object-contain w-6 aspect-square" alt="Floor level icon" />
                  <p class="mt-1.5">{{$product->pisos}}º piso</p>
                </div>
                @endif

                @if($product->mascota)  
                <div class="flex flex-col items-center whitespace-nowrap min-h-[50px] w-[60px]">
                  <img loading="lazy" src="{{asset('images/svg/mascota.svg')}}" class="object-contain w-6 aspect-square" alt="Pet friendly icon" />
                  <p class="mt-1.5">Mascota</p>
                </div>
                @endif

                @if($product->mobiliado)  
                <div class="flex flex-col items-center whitespace-nowrap min-h-[50px] w-[60px]">
                  <img loading="lazy" src="{{asset('images/svg/mobiliado.svg')}}" class="object-contain w-6 aspect-square" alt="Furnished icon" />
                  <p class="mt-1.5">Mobiliado</p>
                </div>
                @endif
                
                @if(!empty($product->movilidad))  
                <div class="flex flex-col items-center whitespace-nowrap min-h-[50px] w-[60px]">
                  <img loading="lazy" src="{{asset('images/svg/movilidad.svg')}}" class="object-contain w-6 aspect-square" alt="Proximity icon" />
                  <p class="mt-1.5">{{$product->movilidad}}</p>
                </div>
                @endif
              </div>
            </div>


            <section class="flex flex-col bg-white rounded-2xl">
              @if ($product->description)
                <div class="flex flex-col w-full">
                  <header class="flex gap-4 items-center self-start">
                    <div class="flex gap-1.5 items-center self-stretch p-3 my-auto w-10 h-10 bg-emerald-300 rounded-3xl">
                      <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/c687d39e503ce7592bc6e5025bf338b8588a42a5f15e6d7869d3331e3572af84?placeholderIfAbsent=true&apiKey=5531072f5ff9482693929f17ec98446f" class="object-contain aspect-square w-[18px]" alt="" />
                    </div>
                    <h2 class="self-stretch my-auto text-2xl font-Homie_Bold text-[#006258]">Acerca de esta propiedad</h2>
                  </header>
                  <div class="flex-1 shrink gap-2.5 pl-14 mt-4 w-full font-FixelText_Regular text-base leading-6 text-[#000929]">
                      {!! $product->description !!} 
                  </div>
                </div>
              @endif

              @if (!$especificaciones->isEmpty())          
                <section class="flex flex-col p-4 gap-4 mt-10 w-full text-teal-800 bg-white rounded-3xl max-md:max-w-full">
                  @foreach ($especificaciones as $item)
                    <div class="flex flex-col w-full max-md:max-w-full">
                      <h3 class="text-lg font-Homie_Bold text-[#006258]"> {{ $item->tittle }}</h3>
                      <p class="mt-1 font-FixelText_Regular text-base leading-6 text-[#000929]">
                        {{ $item->specifications }}
                      </p>
                    </div>
                  @endforeach
                </section>
              @endif

              @php
                $incluyef = strip_tags($product->incluye);  
                $noincluyef = strip_tags($product->no_incluye);  
              @endphp
              @if ( $incluyef !== '' ||  $noincluyef !== '')
                <section class="flex flex-col mt-10 w-full max-md:max-w-full">
                  <header class="flex gap-4 items-center self-start">
                    <div class="flex gap-1.5 items-center self-stretch p-3 my-auto w-10 h-10 bg-emerald-300 rounded-3xl">
                      <img loading="lazy" src="{{asset('images/img/iconoproduct.png')}}" class="object-contain aspect-square w-[18px]" alt="" />
                    </div>
                    <h2 class="self-stretch my-auto text-2xl font-Homie_Bold text-[#006258]">Inmueble</h2>
                  </header>
                  <div class="flex-1 shrink gap-2.5 pl-14 mt-4 w-full text-base leading-6 max-md:pl-5 max-md:max-w-full">
                     @if (!is_null($product->incluye) && $incluyef !== '')
                      <h3 class="font-bold leading-6 text-[#006258] font-FixelText_Semibold ">Incluye</h3>
                      <p class="font-FixelText_Regular text-base leading-6 text-[#000929]">
                        {!! $product->incluye !!} 
                      </p>
                     @endif
                     @if (!is_null($product->no_incluye) && $noincluyef !== '')
                      <h3 class="font-bold leading-6 text-[#006258] font-FixelText_Semibold  mt-4">No Incluye</h3>
                      <p class="font-FixelText_Regular text-base leading-6 text-[#000929]">
                        {!! $product->no_incluye !!} 
                      </p>
                    @endif
                  </div>
                </section>
              @endif
              
              @php
                $disponiblef = strip_tags($product->disponible);  
                $nodisponiblef = strip_tags($product->no_disponible);  
              @endphp  
              @if ( $disponiblef !== '' ||  $nodisponiblef !== '')
                <section class="flex flex-col mt-10 w-full max-md:max-w-full">
                  <header class="flex gap-4 items-center self-start">
                    <div class="flex gap-1.5 items-center self-stretch p-3 my-auto w-10 h-10 bg-emerald-300 rounded-3xl">
                      <img loading="lazy" src="{{asset('images/img/iconoproduct.png')}}" class="object-contain aspect-square w-[18px]" alt="" />
                    </div>
                    <h2 class="self-stretch my-auto text-2xl font-Homie_Bold text-[#006258]">Condominio</h2>
                  </header>
                  <div class="flex-1 shrink gap-2.5 pl-14 mt-4 w-full text-base leading-6 text-slate-950 max-md:pl-5 max-md:max-w-full">
                    @if (!is_null($product->disponible) && $disponiblef !== '')
                      <h3 class="font-bold leading-5 text-[#006258] font-FixelText_Semibold">Disponible</h3>
                      <p class="font-FixelText_Regular text-base leading-6 text-[#000929]">
                        {!! $product->disponible !!} 
                      </p>
                    @endif
                    @if (!is_null($product->no_disponible) && $nodisponiblef !== '')
                      <h3 class="font-bold leading-5 text-[#006258] font-FixelText_Semibold  mt-4">Indisponible</h3>
                      <p class="font-FixelText_Regular text-base leading-6 text-[#000929]">
                        {!! $product->no_disponible !!} 
                      </p>
                    @endif  
                    <h3 class="font-bold leading-5 text-[#006258] font-FixelText_Semibold mt-4">¿Te gustó el condominio?</h3>
                    <p class="font-FixelText_Regular text-base leading-6 text-[#000929]">
                      Obtenga más información y vea si hay otros apartamentos disponibles allí.
                    </p>
                  </div>
                </section>
              @endif
              {{-- <button class="gap-2.5 self-stretch font-FixelText_Semibold tracking-wide px-6 py-3 mt-10 w-full text-base font-bold text-[#73F7AD] bg-[#009A84] rounded-xl min-h-[40px] max-md:px-5 max-md:max-w-full">
                Conocer Departamento
              </button> --}}
            </section>
          
          </div>

          
          <div class="flex flex-col lg:sticky lg:top-0 justify-center rounded-2xl w-full lg:w-[400px] order-1 lg:order-2">
                <section class="flex flex-col p-0 lg:p-6 bg-white rounded-2xl">
                  {{-- <h2 class="gap-10 self-stretch w-full text-lg font-FixelText_Bold text-[#006258]">S/ 333,00 / noche</h2> --}}
                  <div class="flex flex-row gap-4 items-start mt-4 w-full font-medium px-4 justify-center">
                      {{-- <div class="flex flex-col w-full">
                          <label for="arrival-date" class="text-lg font-FixelText_Medium text-[#000929]">Seleccione fechas</label>
                          <div class="flex gap-3 justify-center items-center px-4 py-1 mt-2 w-full text-sm rounded-lg border border-solid border-teal-600 border-opacity-30">
                              <input type="text" id="arrival-date" class="flex-1 shrink font-FixelText_Medium self-stretch my-auto basis-0 bg-transparent focus:ring-0 focus:border-0 border-none selection:text-[#000929] text-[#006258] placeholder:text-opacity-30" value="2024-07-13" aria-label="Fecha de llegada" />
                          </div>
                      </div> --}}

                      <div class="flex flex-col w-full">
                            <label for="date-range-picker" class="text-lg font-FixelText_Medium text-[#000929] mb-2">Seleccione fechas</label>
                            <div class="date-input-container flex flex-row gap-1 justify-center items-center px-4 mt-2 w-full text-sm rounded-lg border border-solid border-teal-600 border-opacity-80">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" text-gray-500">
                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                                    <line x1="16" x2="16" y1="2" y2="6"></line>
                                    <line x1="8" x2="8" y1="2" y2="6"></line>
                                    <line x1="3" x2="21" y1="10" y2="10"></line>
                                </svg>
                                <input 
                                    id="date-range-picker" 
                                    type="text" 
                                    placeholder="Fecha de llegada - salida" 
                                    class="date-input mt-1 text-sm font-FixelText_Medium bg-transparent focus:ring-0 focus:border-0 border-none selection:text-[#000929] placeholder:text-[#006258] text-[#006258] placeholder:text-opacity-80" 
                                    readonly
                                >
                            </div>
                            <div id="selected-range-container" class="selected-range mt-2" style="display: none;">
                              <p class="text-sm font-medium">Rango seleccionado:</p>
                              <p id="selected-range-text" class="text-sm"></p>
                            </div>
                      </div>
                        
                  </div>
                  <div class="flex gap-3 items-center mt-8 w-full text-sm font-medium text-center text-teal-800">
                      <div class="flex justify-center items-center cursor-pointer rounded-l-3xl">
                          <button class="py-2.5 px-5 text-lg font-Helvetica_Bold rounded-full bg-[#009A84] m-1 text-white" id=disminuir
                              type="button">-</button>
                      </div>
                      <div id="cantidadSpan" data-max-personas="{{ $product->precioservicio > 0 ? $product->precioservicio : 2 }}" class="flex-1 shrink gap-2.5 font-FixelText_Semibold self-stretch p-4 h-full rounded-lg border border-teal-600 border-solid bg-slate-50 min-w-[140px]">
                        <span>1</span> personas
                      </div>
                      <div class="flex justify-center items-center cursor-pointer rounded-full">
                        <button class="py-2.5 px-[18px] text-lg font-Helvetica_Bold rounded-full bg-[#009A84] m-1 text-white" id=aumentar
                            type="button">+</button>
                      </div>
                  </div>

                  {{-- <a id="cotizar" data-product-sku="{{ $product->sku }}" class="bg-green-500 p-2 text-white my-2">Calcular</a> --}}

                  <section class="flex flex-col mt-8 w-full">
                      <div class="flex flex-col p-3 w-full text-base font-bold text-[#006258] rounded-lg bg-slate-50">
                          <h3 class="text-[#006258] font-FixelText_Bold text-base">Resumen</h3>
                          <div class="flex flex-col pb-3 mt-4 w-full border-b border-[#006258] font-FixelText_Regular text-[#000929] text-opacity-50">
                              <div class="flex gap-10 justify-between items-center w-full">
                                  <div class="flex gap-1 items-center self-stretch my-auto">
                                      <span id="cantidadnoches">0</span>noches
                                      {{-- <img loading="lazy" src="{{asset('images/svg/alert.svg')}}" class="object-contain shrink-0 self-stretch my-auto w-4 aspect-square" alt="" /> --}}
                                  </div>
                                  
                                  <span id="costonoches" class="self-stretch my-auto">Calculando</span>
                              </div>
                              <div class="flex gap-10 justify-between items-center w-full">
                                <div class="flex gap-1 items-center self-stretch my-auto">
                                    <span id="cantidad-personas-resumen">1</span> persona(s)
                                </div>
                                <span id="costo-personas" class="self-stretch my-auto">$ 0</span>
                              </div>
                              @if ($product->preciolimpieza && $product->preciolimpieza > 0)
                                <div class="flex gap-10 justify-between items-center mt-1 w-full">
                                  <div class="flex gap-1 items-center self-stretch my-auto">
                                      <span>Tasa de limpieza</span>
                                      {{-- <img loading="lazy" src="{{asset('images/svg/alert.svg')}}" class="object-contain shrink-0 self-stretch my-auto w-4 aspect-square" alt="" /> --}}
                                  </div>
                                  <span class="self-stretch my-auto">$ {{$product->preciolimpieza}}</span>
                                </div>
                              @endif

                              @if (!$serviciosextras->isEmpty())
                                  <p class="text-[#006258] font-FixelText_Bold text-base mt-3">Extras: </p>
                                  <div class="flex flex-col gap-1 mt-1">
                                      @foreach ($serviciosextras as $items)
                                          <div class="flex gap-10 justify-between items-center w-full">
                                              <div class="flex gap-1 items-center">
                                                  <label for="servicio_extra_{{ $items->id }}" class="flex items-center gap-1 line-clamp-1">
                                                      <span>{{ $items->service }}</span>
                                                      {{-- <img 
                                                          loading="lazy" 
                                                          src="{{ asset('images/svg/alert.svg') }}" 
                                                          class="object-contain w-4 aspect-square" 
                                                          alt="" 
                                                      /> --}}
                                                  </label>
                                              </div>
                                              <div class="flex flex-row items-center justify-center gap-1">
                                                <span class="mt-1">$ {{ $items->price }}</span>
                                                <input 
                                                        type="checkbox" 
                                                        name="servicios_extras[]" 
                                                        value="{{ $items->id }}" 
                                                        id="servicio_extra_{{ $items->id }}" 
                                                        class="w-4 h-4 focus:ring-0 ring-0 text-[#006258] rounded-sm servicio-extra"
                                                  >
                                               </div>
                                          </div>
                                      @endforeach
                                  </div>
                              @endif
                              
                              {{-- @if ($product->precioservicio)
                              <div class="flex gap-10 justify-between items-center mt-3 w-full">
                                  <div class="flex gap-1 items-center self-stretch my-auto">
                                      <span>Tasa de servicio</span>
                                      <img loading="lazy" src="{{asset('images/svg/alert.svg')}}" class="object-contain shrink-0 self-stretch my-auto w-4 aspect-square" alt="" />
                                  </div>
                                  <span class="self-stretch my-auto">S/ {{$product->precioservicio}}</span>
                              </div>
                              @endif --}}
                          </div>
                          <div class="flex gap-10 justify-between items-center mt-4 w-full text-lg font-FixelText_Bold">
                              <span class="self-stretch my-auto">Total</span>
                              <span class="self-stretch my-auto" id="costototal">Selecciona fechas</span>
                          </div>
                      </div>
                      <p class="self-center mt-2 text-xs font-medium text-center text-slate-950 font-FixelText_Medium">
                          Aún no se te cobrará
                      </p>
                  </section>
                  <div class="flex flex-col mt-8 w-full text-sm font-bold">
                    @if ($product->status == 1 && $product->visible == 1)
                      <button id="btnAgregarCarritoPr" data-id="{{ $product->id }}" class="gap-2.5 self-stretch px-6 py-3 w-full font-FixelText_Semibold text-base text-[#73F7AD] bg-[#009A84] rounded-xl">
                          Reservar ahora
                      </button>
                    @endif
                      {{-- <button class="gap-2.5 self-stretch px-6 py-3 mt-3 w-full text-teal-600 whitespace-nowrap rounded-xl border border-teal-600 border-solid">
                          Descartar
                      </button> --}}
                  </div>
                </section>
          </div>
          
        </section>

        <section class="w-full px-[5%] py-12 overflow-visible mt-4 lg:mt-8" style="overflow-x: visible">
          <div class="flex flex-col md:flex-row justify-between items-start md:items-center w-full gap-10">
            <div class="flex flex-col gap-3 max-w-2xl">
              <h1 class="text-3xl lg:text-4xl font-Homie_Bold text-[#002677]">Nuestras propiedades</h1>
              <p class="text-lg text-[#000929] font-FixelText_Regular">Conoce acá todas las propiedades exclusivas que  tenemos disponibles. 
                Disfruta de una estadía  perfecta en las mejores zonas de Lima.</p>
            </div>
            <div>
              <a href="/catalogo" class="bg-[#00897B] text-[#73F7AD] px-4 py-4 rounded-xl font-FixelText_Semibold">
                Ver todos los departamentos</a>
            </div>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 md:flex-row gap-4 lg:gap-8 mt-7 w-full">
            @foreach ($ProdComplementarios->take(3) as $item)      
               <x-product.container width="col-span-1 " bgcolor="bg-[#FFFFFF]" :item="$item" />
            @endforeach
          </div>
        </section>

  </main>

  <div id="modalgaleriatotal" class="modal !bg-transparent !px-[0px] !py-[0px] !z-50" style="display: none; max-width: 650px !important; width: 100% !important;">
      <div class=" !bg-transparent flex flex-col gap-3">
          <div class="">
            <div class="swiper galeriadeimagenes">
              <div class="swiper-wrapper">
                
                @foreach ($product->galeria as $index => $image)
                  <div class="swiper-slide">
                    <img loading="lazy" src="{{ asset($image->imagen) }}" class="object-contain w-full max-h-[450px] rounded-xl overflow-hidden"/>
                  </div>
                @endforeach

                @if ($product->imagen_2)
                  <div class="swiper-slide">
                    <img loading="lazy" src="{{ asset($product->imagen_2) }}" class="object-contain w-full max-h-[450px] rounded-xl overflow-hidden"/>
                  </div>
                @endif
                @if ($product->imagen_2)
                  <div class="swiper-slide">
                    <img loading="lazy" src="{{ asset($product->imagen_3) }}" class="object-contain w-full max-h-[450px] rounded-xl overflow-hidden"/>
                  </div>
                @endif
                @if ($product->imagen_2)
                  <div class="swiper-slide">
                    <img loading="lazy" src="{{ asset($product->imagen_4) }}" class="object-contain w-full max-h-[450px] rounded-xl overflow-hidden"/>
                  </div>
                @endif
                @if ($product->image_texture)
                  <div class="swiper-slide">
                    <img loading="lazy" src="{{ asset($product->image_texture) }}" class="object-contain w-full max-h-[450px] rounded-xl overflow-hidden"/>
                  </div>
                @endif  
              </div>
            </div>
            <div class="swiper-galeria-prev absolute top-1/2 -translate-y-1/2 -left-2 lg:-left-5 z-50 bg-white rounded-full"><i class="fa-solid fa-circle-chevron-left text-5xl text-[#006258]"></i></div>
            <div class="swiper-galeria-next absolute top-1/2 -translate-y-1/2 -right-2 lg:-right-5 z-50 bg-white rounded-full"><i class="fa-solid fa-circle-chevron-right text-5xl text-[#006258]"></i></div>
          </div>
      </div>
  </div>

@section('scripts_importados')
  

  <script>
    document.addEventListener("DOMContentLoaded", function() {
        const latitude = parseFloat("{{ $product->latitud }}") ?? 0;
        const longitude = parseFloat("{{ $product->longitud }}") ?? 0;
        const mapElement = document.getElementById("map");

        // Si no hay coordenadas válidas, oculta el contenedor del mapa
        if (isNaN(latitude) || isNaN(longitude) || latitude === 0 || longitude === 0) {
            mapElement.style.display = "none"; // Oculta el div#map
        }
   });
  </script>

  <script>
    function copiarEnlace() {
        // Obtener la URL actual
        var url = window.location.href;
        // Crear un elemento temporal para copiar
        const inputTemp = document.createElement('input');
        inputTemp.value = url;
        document.body.appendChild(inputTemp);
        inputTemp.select();
        // Copiar al portapapeles
        document.execCommand('copy');
        // Eliminar el elemento temporal
        document.body.removeChild(inputTemp);
        // Mostrar notificación (opcional)
       
        Swal.fire({
            title: 'Enlace copiado', 
            text: 'Enlace copiado al portapapeles: '. url,
            icon: 'warning'
        });
        
    }
  </script>

  <script type="text/javascript">
      $(document).ready(function(){
          var latitude = {{ $product->latitud ?? 0}};
          var longitude = {{ $product->longitud ?? 0}};

          var location = [
              ['center', latitude, longitude],
          ];

          var mylatlng= {
              lat:location[0][1],
              lng: location[0][2]
          };

          var map= new google.maps.Map(document.getElementById("map"),{
              zoom:15,
              center: mylatlng,
              // styles: darkModeStyle
          });
          for(var i=0; i< location.length; i++){
              new google.maps.Marker({
                  position: new google.maps.LatLng(location[i][1],location[i][2]),
                  map: map
              });
          }
      });   
  </script>

  <script>
    $(document).ready(function () {
        $(document).on('click', '.galeriatotal', function () {
            $(`#modalgaleriatotal`).modal({
                show: true,
                fadeDuration: 400,
            });
        });
    });
  </script>

  <script>
      let serviciosExtras = [];
      let costoTotalFinal = 0;
      let disabledDates = @json($disabledDates);
      const fechasGuardadas = localStorage.getItem('fechasBusqueda');
      let fechaInicio;
      let fechaFin;
      let fechasValidas = false;
      let dateRange = [];

      document.addEventListener('DOMContentLoaded', function() {
        // Convertir formattedDisabledDates a formato compatible con Flatpickr
        let blockedDates = disabledDates;

        // Función para obtener todas las fechas entre dos fechas (inclusive)
        function getDatesBetween(startDate, endDate) {
            const dates = [];
            let currentDate = new Date(startDate);
            const end = new Date(endDate);
            
            while (currentDate <= end) {
                dates.push(new Date(currentDate).toISOString().split('T')[0]);
                currentDate.setDate(currentDate.getDate() + 1);
            }
            
            return dates;
        }
        
        // Obtenga todas las fechas reservadas (incluidas las fechas de entrada y salida)
        function getBookedDates() {
            const bookedDates = new Set();
            
            blockedDates.forEach(booking => {
                // Get all dates in the booking range
                const datesInRange = getDatesBetween(booking.checkIn, booking.checkOut);
                // Add all dates to the set
                datesInRange.forEach(date => bookedDates.add(date));
            });
            
            return Array.from(bookedDates);
        }

        // Función para comprobar si una fecha es una fecha de entrada o de salida
        function isCheckInOrCheckOut(date) {
            return blockedDates.some(booking => 
                booking.checkIn === date || booking.checkOut === date
            );
        }

        // function shouldDisableDate(date) {
        //     const dateStr = date.toISOString().split('T')[0];
        //     const isCheckIn = blockedDates.some(b => b.checkIn === dateStr);
        //     const isCheckOut = blockedDates.some(b => b.checkOut === dateStr);
        //     const isBooked = bookedDates.includes(dateStr);

        //     // Caso 1: Día completamente bloqueado (reserva existente)
        //     if (isBooked && !(isCheckIn || isCheckOut)) {
        //         return true;
        //     }

        //     // Caso 2: Es check-in (mitad derecha bloqueada)
        //     if (isCheckIn) {
        //         // Permitir solo como fecha de salida (end date)
        //         return this.isSelectingStartDate;
        //     }

        //     // Caso 3: Es check-out (mitad izquierda bloqueada)
        //     if (isCheckOut) {
        //         // Permitir solo como fecha de entrada (start date)
        //         return !this.isSelectingStartDate;
        //     }

        //     return false;
        // }

        const bookedDates = getBookedDates();
        console.log('Booked Dates:', bookedDates);
        
        // Inicializar Flatpickr
        const flatpickrInstance = flatpickr("#date-range-picker", {
            mode: "range",
            dateFormat: "Y-m-d",
            minDate: "today",
            allowSameDay: false,
            maxDate: new Date().fp_incr(9 * 30), // 9 meses
            locale: {
                firstDayOfWeek: 1,
                rangeSeparator: ' a ',
                weekdays: {
                    shorthand: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                    longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                },
                months: {
                    shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    longhand: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                },
            },
            disable: [
                function(date) {
                    const dateStr = date.toISOString().split('T')[0];
                    // Comprueba si esta fecha ya está reservada
                    if (bookedDates.includes(dateStr)) {
                        // Si es una fecha de entrada o salida, necesitamos un manejo especial.
                        if (isCheckInOrCheckOut(dateStr)) {
                            // Encuentra todas las reservas donde esta fecha es la de entrada o la de salida
                            const relevantBookings = blockedDates.filter(booking => 
                                booking.checkIn === dateStr || booking.checkOut === dateStr
                            );
                            // Si esta fecha es tanto la fecha de salida como la de entrada para diferentes reservas,
                            // Debería estar completamente bloqueado
                            const isCheckOut = relevantBookings.some(booking => booking.checkOut === dateStr);
                            const isCheckIn = relevantBookings.some(booking => booking.checkIn === dateStr);
                            
                            if (isCheckOut && isCheckIn) {
                                return true; // Block completely
                            }
                            
                            // Otherwise, allow it (special handling will be done in onDayCreate)
                            return false;
                        }
                        return true;
                    }
                    
                    return false;
                }
            ],
            onDayCreate: function(dObj, dStr, fp, dayElem) {
                  const dateStr = dayElem.dateObj.toISOString().split('T')[0];

                  // Style check-in dates
                  if (blockedDates.some(booking => booking.checkIn === dateStr)) {
                      dayElem.classList.add('check-in-date');
                  }
                  
                  // Style check-out dates
                  if (blockedDates.some(booking => booking.checkOut === dateStr)) {
                      dayElem.classList.add('check-out-date');
                  }
                  
                  // Style dates that are both check-in and check-out
                  if (blockedDates.some(booking => booking.checkIn === dateStr) && 
                  blockedDates.some(booking => booking.checkOut === dateStr)) {
                      dayElem.classList.add('check-in-out-date');
                  }
              },
            onChange: function(selectedDates, dateStr) {
                
                if (selectedDates.length === 2) {
                    
                    // Convertir a formato YYYY-MM-DD para el backend
                    const checkin = selectedDates[0].toISOString().split('T')[0];
                    const checkout = selectedDates[1].toISOString().split('T')[0];
                   
                    const contieneReservaCompleta = blockedDates.some(reserva => {
                        return reserva.checkIn >= checkin && reserva.checkOut <= checkout;
                    });

                    if (contieneReservaCompleta) {
                        Swal.fire({
                            title: 'Rango inválido',
                            text: 'El rango seleccionado contiene una reserva completa en medio. Selecciona fechas que no crucen reservas existentes.',
                            icon: 'warning'
                        });
                        flatpickrInstance.clear();
                        $('#cantidadnoches').text(0);
                        return;
                    }

                    // Calcular noches
                    const nights = Math.ceil((selectedDates[1] - selectedDates[0]) / (1000 * 60 * 60 * 24));

                    if (nights < 1) {
                        Swal.fire({
                            title: 'Rango inválido',
                            text: 'Debe haber al menos una noche entre el check-in y el check-out',
                            icon: 'warning'
                        });
                        return;
                    }

                    $('#cantidadnoches').text(nights);
                    
                    // Guardar fechas para el cálculo
                    $('#date-range-picker').data('checkin', checkin);
                    $('#date-range-picker').data('checkout', checkout);
                    
                    // Calcular precios
                    cotizarPrecios();

                } 

                localStorage.removeItem('fechasBusqueda');
            }
        }); 

        const formattedDisabledDates = (Array.isArray(disabledDates) ? disabledDates : [])
        .map(date => moment(date, 'DD/MM/YYYY').format('YYYY-MM-DD'));

        if (fechasGuardadas) {
          try {
                const fechas = JSON.parse(fechasGuardadas);
                
                // Verificar formato de fechas (DD/MM/YYYY)
                if (!/^\d{2}\/\d{2}\/\d{4}$/.test(fechas.llegada) || !/^\d{2}\/\d{2}\/\d{4}$/.test(fechas.salida)) {
                    throw new Error('Formato de fecha inválido');
                }
                
                // Verificar si hay fechas bloqueadas en el rango
                if (!tieneFechasBloqueadas(fechas.llegada, fechas.salida, formattedDisabledDates)) {
                    // Calcular noches válidas
                    const noches = calcularNochesValidas(fechas.llegada, fechas.salida, formattedDisabledDates);
                    
                    if (noches > 0) {
                        // Convertir fechas a formato YYYY-MM-DD para el backend
                        const checkin = moment(fechas.llegada, 'DD/MM/YYYY').format('YYYY-MM-DD');
                        const checkout = moment(fechas.salida, 'DD/MM/YYYY').format('YYYY-MM-DD');
                        
                        // Actualizar UI
                        $('#cantidadnoches').text(noches);
                        $('#date-range-picker').data('checkin', checkin);
                        $('#date-range-picker').data('checkout', checkout);

                        flatpickrInstance.setDate([checkin, checkout], false);

                        // Calcular precios después de un pequeño retraso
                        setTimeout(() => {
                            cotizarPrecios();
                        }, 100);
                    } else {
                        Swal.fire({
                            title: 'Fechas no disponibles',
                            text: 'Todas las fechas en el rango seleccionado están bloqueadas.',
                            icon: 'warning'
                        });
                    }
                } else {
                    Swal.fire({
                        title: 'Fechas no disponibles',
                        text: 'Algunas fechas previamente seleccionadas están bloqueadas.',
                        icon: 'warning'
                    });
                }
            } catch (e) {
                console.error('Error al procesar fechas guardadas:', e);
                localStorage.removeItem('fechasBusqueda');
            }
        }

      });

      function calcularCostoPorPersonas(cantidadPersonas) {
          // Obtener los rangos de personas desde el backend
          const personRanges = @json($product->person_ranges ?? []);
          
          // Si no hay rangos definidos, no hay costo extra
          if (personRanges.length === 0) {
              return 0;
          }
          
          // Ordenar los rangos por cantidad mínima (ascendente)
          personRanges.sort((a, b) => a.min - b.min);
          
          let costoExtra = 0;
          
          // Recorremos cada rango para calcular el costo
          for (let i = 0; i < personRanges.length; i++) {
              const range = personRanges[i];
              const nextRange = personRanges[i + 1];
              
              // Determinar el límite superior del rango actual
              const upperLimit = nextRange ? nextRange.min - 1 : Infinity;
              
              // Si la cantidad de personas está dentro de este rango
              if (cantidadPersonas >= range.min && cantidadPersonas <= upperLimit) {
                  // Calcular cuántas personas están por encima del mínimo base (generalmente 2)
                  const personasExtras = Math.max(0, cantidadPersonas - range.min + 1);
                  
                  // Aplicar el precio del rango a las personas extras
                  costoExtra = personasExtras * range.price;
                  break;
              }
          }
          
          return costoExtra;
      }

      function cotizarPrecios() {
          let productSku = @json($product->sku);
          let checkin = $('#date-range-picker').data('checkin');
          let checkout = $('#date-range-picker').data('checkout');
          let cantidadPersonas = parseInt($('#cantidadSpan span').text());
          serviciosExtras = [];
          
        
          if (!checkin || !checkout) {
              Swal.fire({
                  title: 'Selección Fallida',
                  text: 'Por favor, selecciona un rango de fechas válido.',
                  icon: 'warning',
              });
              return;
          }

          $('#cantidad-personas-resumen').text(cantidadPersonas);
          $('#costototal').text("Calculando...");
          $('#btnAgregarCarritoPr').prop('disabled', true);


          $('input[name="servicios_extras[]"]:checked').each(function() {
              serviciosExtras.push($(this).val());
          });


          $.ajax({
              url: "{{ route('producto.prices') }}",
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}',
              },
              data: JSON.stringify({
                  id: productSku, // SKU del producto
                  checkin: checkin, // Fecha de llegada
                  checkout: checkout, // Fecha de salida
                  servicios: serviciosExtras, // Servicios extras
                  personas: cantidadPersonas
              }),
              success: function(response) {
                  if(response) {
                      $('#costonoches').text("$ " + response.data.totalCost);
                      // let total = response.data.totalCost + {{ $product->preciolimpieza ?? 0.00 }};
                      const costoPorPersonas = calcularCostoPorPersonas(cantidadPersonas);
                      $('#costo-personas').text("$ " + costoPorPersonas);

                      const totalConPersonas = response.data.costoTotalFinal + costoPorPersonas;
                      $('#costototal').text("$ " + totalConPersonas);
                      costoTotalFinal = totalConPersonas;
                  } else {
                      $('#costonoches').text('0.00');
                      $('#costo-personas').text('0.00');
                  }
                  $('#btnAgregarCarritoPr').prop('disabled', false);
              },
              error: function(xhr) {
                  Swal.fire({
                      title: 'Error',
                      text: 'Ocurrió un error inesperado.',
                      icon: 'error',
                  });
              }
          });
      }

      function tieneFechasBloqueadas(checkin, checkout, blockedDates) {
            const fechaInicio = moment(checkin, 'DD/MM/YYYY');
            const fechaFin = moment(checkout, 'DD/MM/YYYY');
            
            for (let m = fechaInicio.clone(); m.isBefore(fechaFin); m.add(1, 'days')) {
                const fechaStr = m.format('YYYY-MM-DD');
                if (blockedDates.includes(fechaStr)) {
                    return true;
                }
            }
            return false;
      }

      function calcularNochesValidas(checkin, checkout, blockedDates) {
        const fechaInicio = moment(checkin, 'DD/MM/YYYY');
        const fechaFin = moment(checkout, 'DD/MM/YYYY');
        let nochesValidas = 0;
        
        for (let m = fechaInicio.clone(); m.isBefore(fechaFin); m.add(1, 'days')) {
            const fechaStr = m.format('YYYY-MM-DD');
            if (!blockedDates.includes(fechaStr)) {
                nochesValidas++;
            }
        }
        return nochesValidas;
      }

      $(document).ready(function () {
        $('.servicio-extra').on('change', function () {
            cotizarPrecios();
        });
      })

  </script>
  
  <script>

    function capitalizeFirstLetter(string) {
      string = string.toLowerCase()
      return string.charAt(0).toUpperCase() + string.slice(1);
    }
    
    $('#disminuir').on('click', function() {
      let cantidad = parseInt($('#cantidadSpan span').text());
      if (cantidad > 1) {
        cantidad--;
        $('#cantidadSpan span').text(cantidad);
        cotizarPrecios();
      }
    })
    
    $('#aumentar').on('click', function() {
      let cantidad = parseInt($('#cantidadSpan span').text());
      let maxPersonas = parseInt($('#cantidadSpan').data('max-personas'));
      
      if (cantidad < maxPersonas) {
          cantidad++;
          $('#cantidadSpan span').text(cantidad);
          cotizarPrecios(); 
      }else {
        Swal.fire({
            title: 'Límite alcanzado',
            text: `El máximo de personas permitido es ${maxPersonas}`,
            icon: 'warning'
        });
      }
    })
  </script>

  <script>
    var galeria = new Swiper(".galeriadeimagenes", {
      slidesPerView: 1,
      autoHeight: true,
      spaceBetween:20,
      loop: true,
      centeredSlides: false,
      initialSlide: 0, 
      allowTouchMove: true,
      autoplay: {
        delay: 5500,
        disableOnInteraction: true,
        pauseOnMouseEnter: true
      },
      navigation: {
                nextEl: ".swiper-galeria-next",
                prevEl: ".swiper-galeria-prev",
            },
      });
  </script>

  <script>
    
    // let articulosCarrito = [];
    /* 
        function deleteOnCarBtn(id, operacion) {
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


        } */

    // function calcularTotal() {
    //   let articulos = Local.get('carrito')
    //   let total = articulos.map(item => {
    //     let monto
    //     if (Number(item.descuento) !== 0) {
    //       monto = item.cantidad * Number(item.descuento)
    //     } else {
    //       monto = item.cantidad * Number(item.precio)
    //     }
    //     return monto
    //   })
    //   const suma = total.reduce((total, elemento) => total + elemento, 0);
    //   $('#itemsTotal').text(`S/. ${suma.toFixed(2)} `)
    // }

    /*  function addOnCarBtn(id, operacion) {
       const prodRepetido = articulosCarrito.map(item => {
         if (item.id === id) {
           item.cantidad += Number(1);
           return item; // retorna el objeto actualizado 
         } else {
           return item; // retorna los objetos que no son duplicados 
         }

       });
       Local.set('carrito', articulosCarrito)
       // localStorage.setItem('carrito', JSON.stringify(articulosCarrito));
       limpiarHTML()
       PintarCarrito()
    } */

    var appUrl = <?php echo json_encode($url_env); ?>;
    $(document).ready(function() {
      articulosCarrito = Local.get('carrito') || [];
      // PintarCarrito();
    });

    function limpiarHTML() {
      //forma lenta 
      /* contenedorCarrito.innerHTML=''; */
      $('#itemsCarrito').html('')
    }

    $('#btnAgregarCombo').on('click', async function() {
      const offerId = this.getAttribute('data-id')
      const res = await fetch(`/api/offers/${offerId}`)
      const data = await res.json()
      let nombre = `<b>${data.producto}</b><ul class="mb-1">`
      data.products.forEach(product => {
        nombre +=
          `<li class="text-xs text-nowrap overflow-hidden text-ellipsis w-[270px]">${product.producto}</li>`
      })
      nombre += '</ul>'

      let newcarrito
      articulosCarrito = Local.get('carrito') ?? []
      const index = articulosCarrito.findIndex(item => item.id == data.id && item.isCombo)

      if (index != -1) {

        articulosCarrito = articulosCarrito.map(item => {
          if (item.isCombo && item.id == data.id) {
            item.nombre = nombre
            item.cantidad++
          }
          return item
        })
      } else {

        articulosCarrito = [...articulosCarrito, {
          "id": data.id,
          "isCombo": true,
          "producto": nombre,
          "descuento": data.descuento,
          "precio": data.precio,
          "imagen": data.imagen ? `${appUrl}${data.imagen}` : `${appUrl}/images/img/noimagen.jpg`,
          "cantidad": 1,
          "color": null
        }]

      }

      Local.set('carrito', articulosCarrito)
      limpiarHTML()
      PintarCarrito()
      mostrarTotalItems()

      Swal.fire({
        icon: "success",
        title: `Combo agregado correctamente`,
        showConfirmButton: true
      });
    })

    $('#addWishlist').on('click', function() {
      $.ajax({
        url: `{{ route('wishlist.store') }}`,
        method: 'POST',
        data: {
          _token: $('input[name="_token"]').val(),
          product_id: '{{ $product->id }}'
        },
        success: function(response) {

          if (response.message === 'Producto agregado a la lista de deseos') {
            $('#addWishlist').removeClass('bg-[#99b9eb]').addClass('bg-[#0D2E5E]');
          } else {
            $('#addWishlist').removeClass('bg-[#0D2E5E]').addClass('bg-[#99b9eb]');
          }
          Swal.fire({
            icon: 'success',
            title: response.message,
            showConfirmButton: false,
            timer: 1500
          });
        },
        error: function(error) {
          console.log(error);
        }
      });
    })
  </script>

  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@stop

@stop
