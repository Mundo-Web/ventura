<div class="bg-[#F3F5F7] md:bg-white py-5 md:py-0 font-FixelText_Semibold">
  <div class="w-11/12 md:w-full mx-auto">
    <div class="basis-5/12 flex flex-col gap-5">
      <div class="flex flex-col gap-5">
        <div class="rounded-full w-24 h-24 bg-[#E9EDEF] flex justify-center items-center relative">
          <img class="w-full h-full rounded-full" src="{{ Auth::user()->profile_photo_url }}" width="32" height="32"
            alt="{{ Auth::user()->name }}" />
          <label for="upload_image"
            class="bg-[#00897b] rounded-full w-7 h-7 flex justify-center items-center absolute bottom-0 right-0 cursor-pointer">
            <img src="{{ asset('/images/svg/upload_photo.svg') }}" alt="upload photo" />
          </label>
          <form action="{{ route('cambiofoto') }}" id="avatarform" method="POST" enctype='multipart/form-data'>
            @csrf
            <input type="hidden" name="name" value="{{ $user->id }}">
            <input type="file" id="upload_image" name="imageuser" accept="image/*" class="hidden" />
          </form>
        </div>

        <div>
          <p class="font-semibold text-[14px] text-[#0A3054]">
            {{ $user->name }}
          </p>

          <p class="font-medium text-[12px] text-[#8896A8]">
            {{ $user->email }}
          </p>
        </div>
      </div>
      <div class="flex flex-col gap-4 ">
        <x-link-sidebar href="{{ route('micuenta') }}"> Mi Cuenta </x-link-sidebar>
        {{-- <x-link-sidebar id="direccion" href="{{ route('direccion') }}"> Dirección </x-link-sidebar> --}}
        <x-link-sidebar id="pedidos" href="{{ route('pedidos') }}"> Historial de reservas </x-link-sidebar>
        {{-- <x-link-sidebar id="listadeseos" href="{{ route('listadeseos') }}"> Lista de deseos </x-link-sidebar> --}}




        <form method="POST" action="{{ route('logout') }}" x-data class="group">
          @csrf
          <button type="submit" href="{{ route('logout') }}"
            class="rounded-2xl bg-[#F3F5F7] md:bg-[#FCFCFC] group-hover:bg-[#00897b]  group-hover:text-white text-[#151515] font-medium text-[16px] py-3 px-4 flex justify-between items-center w-64 mt-0 md:mt-[200px]">
            <span>Cerrar Sesión</span>
            <svg width="20" height="18" viewBox="0 0 14 13" fill="none">
              <path class="group-hover:stroke-white"
                d="M4.8533 0.900391H2.38271C2.00829 0.900391 1.6492 1.04789 1.38444 1.31044C1.11969 1.57299 0.970947 1.92909 0.970947 2.30039V10.7004C0.970947 11.0717 1.11969 11.4278 1.38444 11.6903C1.6492 11.9529 2.00829 12.1004 2.38271 12.1004H4.8533M5.02876 6.50039H13.0288M13.0288 6.50039L9.97199 3.30039M13.0288 6.50039L9.97199 9.70039"
                stroke="#151515" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
