@extends('components.public.matrix', ['pagina' => 'index'])

@section('content')

<div class="flex flex-col md:flex-row gap-3 md:gap-10 justify-center items-center px-[5%] md:pl-[5%] md:pr-0">

    <!-- Primer div -->
    <div class="w-full md:w-[55%] text-[#151515] flex flex-col justify-center items-center">
        <div class="w-full flex flex-col gap-5 p-[5%] max-w-xl shadow-lg">
            <div class="flex flex-col gap-5 text-center">
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif
                <h1 class="text-[#006258] font-Homie_Bold text-4xl">Acceso</h1>
                <p class="text-[#000929] text-base font-FixelText_Regular">
                    Inicia sesión utilizando los detalles de la cuenta a continuación
                </p>
            </div>
            <div class="">
                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
                    @csrf
                    <div>
                        <input type="text" placeholder="Tu nombre de usuario o correo electrónico" name="email"
                            id="email" type="email" :value="old('email')" required autofocus
                            class="px-4 py-3.5 w-full text-sm font-FixelText_Regular focus:border-[#006258] focus:ring-[#006258] text-[#006258] placeholder:text-[#00625852] border border-[#00625852] rounded-xl" />
                    </div>

                    <div class="relative w-full">
                        <!-- Input -->
                        <input type="password" placeholder="Contraseña" id="password" name="password" required
                            autocomplete="current-password"
                            class="px-4 py-3.5 w-full text-sm font-FixelText_Regular focus:border-[#006258] focus:ring-[#006258] text-[#006258] placeholder:text-[#00625852] border border-[#00625852] rounded-xl" />
                        <!-- Imagen -->
                        <img src="./images/svg/pass_eyes.svg" alt="password"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer ojopassWord" />
                    </div>

                    <div class="flex gap-3 px-4 flex-col md:flex-row justify-start md:justify-between">
                        <div class="flex flex-row items-center gap-3">
                            <input type="checkbox" id="acepto_terminos" class="w-4 h-4 rounded-sm text-[#006258] border-[#006258] focus:ring-0" />
                            <label for="acepto_terminos" class="text-base font-FixelText_Regular mt-1">Recuérdame
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <div>
                                <a href="{{ route('password.request') }}"
                                    class="font-normal text-base font-FixelText_Semibold text-[#002677]">¿Olvidaste
                                    tu contraseña?</a>
                            </div>
                        @endif

                    </div>

                    <div class="px-4">
                        <input type="submit" value="Iniciar Sesión"
                            class="text-[#ffffff] bg-[#009A84] w-full py-3.5 rounded-3xl cursor-pointer font-FixelText_Semibold tracking-wide" />
                    </div>

                    <div class="flex flex-row justify-center items-centerpx-4">
                        <a href="{{ route('register') }}"
                            class="text-[#006258] w-full py-2 rounded-3xl cursor-pointer font-FixelText_Semibold text-center">Crear
                            una Cuenta</a>
                    </div>

                </form>
                <x-validation-errors class="mt-4" />
            </div>
        </div>
    </div>


    <!-- Segundo div -->
    <div class="w-full md:w-[45%] ">
        <div class="bg-contain bg-center bg-no-repeat w-full h-full">
            <img src="{{ asset('images/img/loginimg.png') }}" class="min-h-[500px] object-contain xl:h-[700px]" />
        </div>
    </div>

</div>

  <script>
    $(document).on("click", '.ojopassWord', function() {


      var input = $(this).siblings('input');

      // Alterna el tipo de entrada entre 'password' y 'text'
      if (input.attr('type') === 'password') {
        input.attr('type', 'text');
      } else {
        input.attr('type', 'password');
      }

    })
  </script>
@stop
