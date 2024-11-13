@extends('components.public.matrix', ['pagina' => 'index'])

@section('css_importados')

@stop

<style>
  #Aboutus .prose {
    width: 100%;
    max-width: 100%;
    text-align: justify;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
  }

  .prose p {

    margin-top: 0 !important;
    margin-bottom: 0 !important;

  }

  @media (max-width: 600px) {
    .fixedWhastapp {
      right: 116px !important;
    }
  }
</style>

@section('content')

  <main class="bg-[#FAFCFE]">
      <section class="grid grid-cols-1 lg:grid-cols-2 text-left gap-8 xl:gap-16 items-center px-[5%] xl:px-[8%] py-8 lg:py-16">
        <h2 class="text-4xl lg:text-5xl font-bold text-[#006258] px-0 lg:px-[3%] font-Homie_Bold">
          {{$nosotrostextos->title1section ?? 'Ingrese un texto'}}
        </h2>
        <p class="text-lg text-[#000929] font-FixelText_Regular">
          {{$nosotrostextos->description1section ?? 'Ingrese un texto'}}
        </p>
      </section>

      <section class="flex flex-row justify-center items-center px-[5%] lg:px-[8%]">
        <img src="{{asset('images/img/vt_nosotros3.png')}}" class="rounded-xl lg:rounded-3xl h-full lg:h-[550px] w-full object-contain" />
      </section>

      <section class="flex flex-col md:flex-row gap-8 md:gap-16 px-[5%] xl:px-[8%] py-14 lg:py-20 text-center items-start" data-aos="fade-up" data-aos-offset="150">
        <article class="flex flex-col flex-1 shrink justify-center basis-0 min-w-[240px]">
            <header class="flex flex-col w-full font-bold text-teal-800">
                <img loading="lazy" src="{{asset('images/img/flecha.png')}}" alt="Nuestra misión icon" class="object-contain self-center w-16 aspect-square">
                <div class="flex flex-col mt-6 w-full">
                    <h2 class="text-base font-FixelText_Bold">{{$nosotrostextos->subtitle3section ?? 'Ingrese un texto'}}</h2>
                    <h3 class="text-3xl lg:text-4xl max-w-md mx-auto font-Homie_Bold text-[#002677]">{{$nosotrostextos->title3section ?? 'Ingrese un texto'}}</h3>
                </div>
            </header>
            <p class="mt-4 text-lg text-[#000929] font-FixelText_Regular">
              {{$nosotrostextos->description3section ?? 'Ingrese un texto'}}
            </p>
        </article>
        <article class="flex flex-col flex-1 shrink basis-0 min-w-[240px]">
            <header class="flex flex-col justify-center w-full font-bold text-teal-800">
                <img loading="lazy" src="{{asset('images/img/lampara.png')}}" alt="Nuestra meta icon" class="object-contain self-center w-16 aspect-square">
                <div class="flex flex-col mt-6 w-full">
                    <h2 class="text-base font-FixelText_Bold">{{$nosotrostextos->subtitle3secondsection ?? 'Ingrese un texto'}}</h2>
                    <h3 class="text-3xl lg:text-4xl max-w-md mx-auto font-Homie_Bold text-[#002677]">{{$nosotrostextos->title3secondsection ?? 'Ingrese un texto'}}</h3>
                </div>
            </header>
            <p class="mt-4 text-lg text-[#000929] font-FixelText_Regular">
              {{$nosotrostextos->description3secondsection ?? 'Ingrese un texto'}}
            </p>
        </article>
      </section>

      <section class="flex flex-col md:flex-row gap-10 lg:gap-20 items-center justify-center pl-[5%] xl:pl-[8%] ">

          <div class="w-full lg:w-3/5 flex flex-col gap-5 xl:max-w-xl mx-auto py-8 lg:py-16 pr-[5%] order-2 md:order-1">
            <h2 class="text-4xl lg:text-5xl font-Homie_Bold text-[#006258]">
              {{$nosotrostextos->title4section ?? 'Ingrese un texto'}}
            </h2>
            <p class="text-lg text-[#000929] font-FixelText_Regular">
              {{$nosotrostextos->description4section ?? 'Ingrese un texto'}}
            </p>
            <div class="flex flex-col sm:flex-row gap-10 mt-5">
              @foreach ($estadisticas as $estadistica)
                  <div class="flex flex-col gap-2">
                      <h2 class="text-4xl lg:text-5xl font-FixelText_Bold text-[#002677]">
                          {{ $estadistica->title }}
                      </h2>
                      <p class="text-sm text-[#009A84] font-FixelText_Medium">{{ $estadistica->description }}</p>
                  </div>
              @endforeach
            </div>
          </div>

          <div class="bg-[#5BE3A4] w-[80%] sm:w-1/2 ml-auto lg:w-2/5 h-[480px] lg:min-h-svh relative order-1 md:order-2">
            <div class="absolute inset-0 flex justify-center items-center -translate-x-10 lg:-translate-x-1/4">
              <img class="h-[500px] lg:h-full py-[5%] lg:py-[10%] object-contain" src="{{asset('images/img/vt_nosotros2.png')}}" />  
            </div>
          </div>

          
      </section>
  </main>

  <!-- Main modal -->
  
  {{-- 
  <div id="modalofertas" class="modal">
    <!-- Modal body -->
    <div class="p-1 ">
      <x-swipper-card-ofertas :items="$popups" id="modalOfertas" />
    </div>
  </div> --}}


@section('scripts_importados')

  <script>
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

      $('#itemsTotal').text(`S/. ${suma} `)

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


@stop

@stop
