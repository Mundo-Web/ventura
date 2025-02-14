<div x-data="{ showAmbiente: false }" @mouseenter="showAmbiente = true" @mouseleave="showAmbiente = false"
  class="flex flex-col relative w-full md:{{ $width }} {{ $bgcolor }} md:min-h-[425px] ">
  <div class="{{ $bgcolor }} product_container basis-4/5 flex flex-col justify-center relative">
    {{-- @php
      echo json_encode($item->tags);
    @endphp --}}

    <div class="absolute top-2 left-2">
      @if ($item->tags)
        @foreach ($item->tags as $tag)
          <div class="px-4 mb-1">
            <span
              class="block font-semibold text-[8px] md:text-[12px] bg-black py-2 px-2 flex-initial w-24 text-center text-white rounded-[5px] relative top-[18px] z-10"
              style="background-color: {{ $tag->color }}">

              {{ $tag->name }}
            </span>
          </div>
        @endforeach
      @endif

    </div>
    
    <div>
      <a href="{{ route('producto', $item->id) }}" class="px-1 py-2 flex flex-col gap-1">
        <div class="relative flex justify-center items-center h-full w-full border aspect-square">
          @php
            $category = $item->categoria();
          @endphp
          @if ($item->imagen)
            <img 
              {{-- x-show="{{ isset($item->imagen_ambiente) }} || !showAmbiente" --}}
              x-transition:enter="transition ease-out duration-300 transform"
              x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
              x-transition:leave="transition ease-in duration-300 transform"
              x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
              src="{{ asset($item->imagen) }}" alt="{{ $item->name }}"
              class="w-full h-full object-cover md:object-cover absolute inset-0"
              onerror="this.onerror=null;this.src='/images/img/noimagen.jpg';" />
          @else
            <img x-show="{{ isset($item->imagen_ambiente) }} || !showAmbiente"
              x-transition:enter="transition ease-out duration-300 transform"
              x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
              x-transition:leave="transition ease-in duration-300 transform"
              x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
              src="{{ asset('images/img/noimagen.jpg') }}" alt="imagen_alternativa"
              class="w-full h-full object-cover md:object-cover absolute inset-0" />
          @endif
          
          {{-- @isset($item->imagen_ambiente)
            @if ($item->imagen_ambiente)
              <img x-show="showAmbiente" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-300 transform"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                src="{{ asset($item->imagen_ambiente) }}" alt="{{ $item->name }}"
                class="w-full h-full object-cover absolute inset-0 object-center"
                onerror="this.onerror=null;this.src='/images/img/noimagen.jpg';" />
            @else
              <img x-show="showAmbiente" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-300 transform"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                src="{{ asset('images/img/noimagen.jpg') }}" alt="imagen_alternativa"
                class="w-full h-full object-contain object-center md:object-cover absolute inset-0" />
            @endif
          @endisset --}}

        </div>
      </a>
      <!-- ------ -->
      {{-- <div class="addProduct text-center flex justify-center h-0">
        <div class="flex  flex-row gap-2">
          <a href="{{ route('producto', $item->id) }}"
            class="font-FixelText_Medium text-base bg-[#006258] py-2 px-6 text-center text-white rounded-3xl h-10">
            Ver producto
          </a>
          <button href="{{ route('producto', $item->id) }}" type="button" id='btnAgregarCarrito'
            title="Agregar al Carrito" data-id="{{ $item->id }}"
            class="flex items-center tippy font-semibold text-[13px] bg-[#FD1F4A]  py-1 px-4 text-center text-white rounded-3xl h-10">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="22" height="22" fill="#FFFFFF">
              <path
                d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96zM252 160c0 11 9 20 20 20l44 0 0 44c0 11 9 20 20 20s20-9 20-20l0-44 44 0c11 0 20-9 20-20s-9-20-20-20l-44 0 0-44c0-11-9-20-20-20s-20 9-20 20l0 44-44 0c-11 0-20 9-20 20z" />
            </svg>

          </button>
        </div>

      </div> --}}
    </div>

  </div>

  <a href="{{ route('producto', $item->id) }}" class="px-1 py-2 flex flex-col gap-1">
    <h2 id="h2Container"
      class="text-lg  text-left line-clamp-2 text-[#002677] text-ellipsis font-Homie_Bold tracking-tight  cortartexto tippy max-h-12 md:min-h-12 mt-3 md:mt-0"
      title="{{ $item->producto }}">
      {{-- {{ mb_strimwidth($item->producto, 0, 100, '...') }} --}}
      {{$item->producto}}
    </h2>

    {{-- <p className="text-[13px] lg:text-base text-left overflow-hidden font-FixelText_Light text-[#000929] cortartexto max-h-12 md:min-h-12 mt-3 md:mt-0">
      {{ mb_strimwidth($item->extract, 0, 95, '...') }}
    </p>  --}}
    {{-- <div class="flex content-between flex-row gap-4 items-center justify-start !font-Helvetica_Medium pb-4">
      @if ($item->descuento == 0)
        <span class="text-[#FD1F4A] text-lg font-bold"> S/. {{ $item->precio }}</span>
      @else
        <div class="flex flex-row gap-2 items-center">
          <span class="text-[#FD1F4A] text-lg font-bold">S/. {{ $item->descuento }}</span>
          <span class="text-[12px] md:text-base text-[#15294C] opacity-80 line-through">S/. {{ $item->precio }}</span>
        </div>
      @endif
    </div> --}}
  </a>

</div>

<style>
  .cortartexto {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    text-overflow: ellipsis;
    max-height: 60px;
  }
</style>

<script>
  $(document).ready(function() {
    tippy('.tippy', {
      arrow: true,
      followCursor: true,
      placement: 'right',

    })
  })
</script>
