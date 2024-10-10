@extends('components.public.matrix', ['pagina' => 'index'])
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
@section('content')
  
    <div class="flex flex-col md:flex-row gap-3 md:gap-10 justify-center items-center px-[5%] md:pl-[5%] md:pr-0">

        <!-- Primer div -->
        <div class="w-full md:w-[55%] text-[#151515] flex flex-col justify-center items-center">
            <div class="w-full flex flex-col gap-5 p-[5%] max-w-xl shadow-lg">
                <div class="flex flex-col gap-5 text-center">
                    <h1 class="text-[#006258] font-Homie_Bold text-4xl">Crear una cuenta</h1>
                    <p class="text-[#000929] text-base font-FixelText_Regular">
                        ¿Ya tienes una cuenta?
                        <a href="{{ route('login') }}"
                            class="text-[#000929] text-base font-FixelText_Semibold">Iniciar
                            Sesión</a>
                    </p>
                </div>
                <div class="">
                    <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-5">
                        @csrf
                        @php
                            if ($errors->any()) {
                                // dd($errors);
                            }
                        @endphp

                        <div>
                            <input type="text" placeholder="Nombre completo" id="name" name="name"
                                :value="old('name')" required autofocus
                                class="px-4 py-3.5 w-full text-sm font-FixelText_Regular focus:border-[#006258] focus:ring-[#006258] text-[#006258] placeholder:text-[#00625852] border border-[#00625852] rounded-xl" />
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <input type="text" placeholder="Correo electrónico" id="email" name="email"
                                :value="old('email')" required
                                class="px-4 py-3.5 w-full text-sm font-FixelText_Regular focus:border-[#006258] focus:ring-[#006258] text-[#006258] placeholder:text-[#00625852] border border-[#00625852] rounded-xl" />
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="relative w-full">
                            <!-- Input -->
                            <input type="password" placeholder="Contraseña" id="password" name="password" required
                                autocomplete="new-password"
                                class="px-4 py-3.5 w-full text-sm font-FixelText_Regular focus:border-[#006258] focus:ring-[#006258] text-[#006258] placeholder:text-[#00625852] border border-[#00625852] rounded-xl" />

                            <!-- Imagen -->
                            <img src="./images/svg/pass_eyes.svg" alt="password"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer ojopassWord" />
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="relative w-full">
                            <!-- Input -->
                            <input type="password" placeholder="Confirmar contraseña" id="password_confirmation"
                                name="password_confirmation" required autocomplete="new-password"
                                class="px-4 py-3.5 w-full text-sm font-FixelText_Regular focus:border-[#006258] focus:ring-[#006258] text-[#006258] placeholder:text-[#00625852] border border-[#00625852] rounded-xl" />
                            <!-- Imagen -->
                            <img src="./images/svg/pass_eyes.svg" alt="password"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer ojopassWord_confirmation" />
                            @error('password_confirmation')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex gap-3">
                            <input type="checkbox" id="acepto_terminos" class="w-4 h-4 rounded-sm text-[#006258] border-[#006258] focus:ring-0" required />
                            <label name="newsletter" id="newsletter" class="text-[#000929] font-normal text-sm font-FixelText_Regular">
                                Acepto la
                                <span class="font-bold font-FixelText_Semibold cursor-pointer open-modal"
                                    data-tipo='PoliticaPriv'> Política de
                                    Privacidad</span>
                            </label>
                        </div>

                        <div class="px-4">
                            <input type="submit" value="Crear Cuenta"
                                class="text-[#ffffff] bg-[#009A84] w-full py-3.5 rounded-3xl cursor-pointer font-FixelText_Semibold tracking-wide" />
                        </div>
                    </form>
                    {{-- <x-validation-errors class="mt-4" /> --}}
                </div>
            </div>
        </div>

        <!-- Segundo div -->
    <div class="w-full md:w-[45%] ">
        <div class="bg-contain bg-center bg-no-repeat w-full h-full">
            <img src="{{ asset('images/img/registerimg.png') }}" class="min-h-[500px] object-contain xl:h-[700px]" />
        </div>
    </div>

    </div>

  <div id="modaalpoliticas" class="modal modalbanner">
    <div class="p-2" id="modal-content">
      <h1 id="modal-title">MODAL POLITICAS</h1>
      <div id="modal-body-content"></div>
    </div>
  </div>

  <script>
    const politicas = @json($politicas);
    const terminos = @json($terminos);

    $(document).on('click', '.open-modal', function() {
      var tipo = $(this).data('tipo');
      var title = '';
      var content = '';
      console.log(politicas)
      console.log(terminos)

      if (tipo == 'PoliticaPriv') {
        title = 'Política de Privacidad';
        content = politicas.content;
      } else if (tipo == 'terminosUso') {
        title = 'Términos y condiciones';
        content = terminos.content;
      }

      $('#modal-title').text(title);
      $('#modal-body-content').html(content);

      $('#modaalpoliticas').modal({
        show: true,
        fadeDuration: 100
      });
    });

    $(document).on("click", '.ojopassWord', function() {


      var input = $(this).siblings('input');

      // Alterna el tipo de entrada entre 'password' y 'text'
      if (input.attr('type') === 'password') {
        input.attr('type', 'text');
      } else {
        input.attr('type', 'password');
      }

    })
    $(document).on("click", '.ojopassWord_confirmation', function() {
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
