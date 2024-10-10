@extends('components.public.matrix', ['pagina' => 'index'])

@section('content')

<div class="flex flex-col md:flex-row gap-3 md:gap-10 justify-center items-center px-[5%] md:pl-[5%] md:pr-0">
    <!-- Primer div -->
    <div class="w-full md:w-[55%] text-[#151515] flex flex-col justify-center items-center">
      <div class="w-full flex flex-col gap-5 p-[5%] max-w-xl shadow-lg">
        <div class="flex flex-col gap-5 text-center md:text-left">
          @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
              {{ session('status') }}
            </div>
          @endif
          <h1 class="text-[#006258] font-Homie_Bold text-4xl">Recuperar contraseña</h1>
          <p class="text-[#000929] text-base font-FixelText_Regular">
              Le enviaremos un correo electrónico para restablecer su contraseña.
          </p>
        </div>
        <div class="">
          <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-5">
            @csrf
            <div>
              <input type="text" placeholder="Correo electrónico" name="email"
                id="email" type="email" :value="old('email')" required autofocus
                class="px-4 py-3.5 w-full text-sm font-FixelText_Regular focus:border-[#006258] focus:ring-[#006258] text-[#006258] placeholder:text-[#00625852] border border-[#00625852] rounded-xl" />
            </div>

            <div class="px-4">
              <input type="submit" value="Enviar"
                class="text-[#ffffff] bg-[#009A84] w-full py-3.5 rounded-3xl cursor-pointer font-FixelText_Semibold tracking-wide" />
            </div>

           <div class="flex flex-row justify-center items-centerpx-4">
              <a href="{{ route('login') }}" 
                class="text-[#006258] w-full py-2 rounded-3xl cursor-pointer font-FixelText_Semibold text-center">Cancelar</a>
            </div>

          </form>
          <x-validation-errors class="mt-4" />
        </div>
      </div>
    </div>


    <!-- Segundo div -->
    <div class="w-full md:w-[45%] ">
      <div class="bg-contain bg-center bg-no-repeat w-full h-full">
          <img src="{{ asset('images/img/restaurarimg.png') }}" class="min-h-[500px] object-contain xl:h-[700px]" />
      </div>
    </div>
</div>

@stop
