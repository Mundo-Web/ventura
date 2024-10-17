@extends('components.public.matrix', ['pagina' => ' '])

@section('css_importados')

@stop


@section('content')

  <main>

    {{-- <section class="font-FixelText_Semibold mt-12 mb-0 md:my-12">
            <div class="flex flex-col w-11/12 mx-auto">
                <div class="flex flex-col gap-10 my-5">
                    <div class="flex gap-1">
                        <a href="index.html" class="font-normal text-[14px] text-[#6C7275]">Home</a>
                        <span>/</span>
                        <a href="#" class="font-semibold text-[14px] text-[#141718]">Mi cuenta</a>
                    </div>
                </div>
            </div>
        </section> --}}

    <section class="font-FixelText_Semibold my-8 md:my-16">
      <div class="flex flex-col gap-12 md:flex-row md:gap-28 w-full md:w-11/12 mx-auto">

        <x-side-section-dashboard :user="$user" />

        <div class="basis-7/12 font-FixelText_Semibold w-11/12 md:w-full mx-auto">
          <form method="POST" class="flex flex-col gap-5 mb-10" enctype='multipart/form-data' id="detalleCuenta">
            @csrf
            <h2 class="text-[20px] font-semibold text-[#151515]">
              Detalles de la cuenta
            </h2>
            <input type="hidden" name="id" value="{{ $user->id }}" />
            <div class="flex flex-col gap-2">
              <label for="nombre_user" class="font-medium text-[12px] text-[#6C7275]">Nombres</label>
              <input id="nombre_user" type="text" placeholder="Nombres" name="name" value="{{ $user->name }}"
                class="w-full py-3 px-4 focus:outline-none focus:ring-[#00897b] focus:border-[#00897b] placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" />
            </div>

            <div class="flex flex-col gap-2">
              <label for="apellido_user" class="font-medium text-[12px] text-[#6C7275]">Apellidos</label>
              <input id="apellido_user" type="text" placeholder="Apellidos" name="lastname"
                value="{{ $user->lastname }}"
                class="w-full py-3 px-4 focus:outline-none focus:ring-[#00897b] focus:border-[#00897b] placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" />
            </div>

            <div class="flex flex-col gap-2">
              <label for="email_user" class="font-medium text-[12px] text-[#6C7275]">E-mail</label>
              <input id="email_user" type="email" placeholder="hola@gmail.com" name="email" value="{{ $user->email }}"
                class="w-full py-3 px-4 focus:outline-none focus:ring-[#00897b] focus:border-[#00897b] placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" />
            </div>

            <div>
              <hr class="bg-[#151515] h-[2px]" />
            </div>

            <h2 class="text-[20px] font-semibold text-[#151515]">
              Contraseña
            </h2>

            <div class="flex flex-col gap-2">
              <label for="contrasenia_anterior" class="font-medium text-[12px] text-[#6C7275]">Contraseña
                actual</label>
              <input id="contrasenia_anterior" type="password" placeholder="*************" name="password"
                class="w-full py-3 px-4 focus:outline-none focus:ring-[#00897b] focus:border-[#00897b] placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" />
            </div>

            <div class="flex flex-col gap-2">
              <label for="contrasenia_nueva" class="font-medium text-[12px] text-[#6C7275]">Nueva
                Contraseña</label>
              <input id="contrasenia_nueva" type="password" placeholder="*************" name="newpassword"
                class="w-full py-3 px-4 focus:outline-none focus:ring-[#00897b] focus:border-[#00897b] placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" />
            </div>

            <div class="flex flex-col gap-2">
              <label for="repetir_contrasenia" class="font-medium text-[12px] text-[#6C7275]">Repetir nueva
                contraseña</label>
              <input id="repetir_contrasenia" type="password" placeholder="*************" name="confirmnewpassword"
                class="w-full py-3 px-4 focus:outline-none focus:ring-[#00897b] focus:border-[#00897b] placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" />
            </div>

            <div class="flex gap-5 flex-col md:flex-row">
              <a type="submit" value="Guardar cambios" id="botonGuardar"
                class="text-white bg-[#00897b] py-3 px-5 focus:ring-[#00897b] focus:border-[#00897b] rounded-2xl cursor-pointer border-2 font-semibold text-[16px] text-center border-none inline-block">Guardar
                cambios</a>

              <a onclick="window.location.href = window.location.href;"
                class="text-[#151515] py-3 px-5 rounded-2xl cursor-pointer font-semibold text-[16px] text-center inline-block border-[1px] border-[#151515]">Cancelar</a>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>



@section('scripts_importados')
  <script>
    $("#upload_image").change(function() {

      const file = this.files[0];

      if (file) {
        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', $('#avatarform input[name="_token"]').val());
        formData.append('id', $('#avatarform input[name="name"]').val());
        $.ajax({

          url: "{{ route('cambiofoto') }}",
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,

          success: function(success) {
            window.location.href = window.location.href;

          },
          error: function(error) {
            console.log(error)
          }

        })
      }

    });


    $("#botonGuardar").click(function(event) {

      event.preventDefault();

      let mensaje = null;
      let alert = "error";

      if ($('#contrasenia_anterior').val() != "" && $('#contrasenia_nueva').val() == "" && $(
          '#repetir_contrasenia').val() == "") {
        mensaje = "Completar los campos para cambiar contraseña";
      } else if ($('#contrasenia_anterior').val() === "" && $('#contrasenia_nueva').val() !== "" && $(
          '#repetir_contrasenia').val() === "") {
        mensaje = "Completar los campos para cambiar contraseña";
      } else if ($('#contrasenia_anterior').val() === "" && $('#contrasenia_nueva').val() === "" && $(
          '#repetir_contrasenia').val() !== "") {
        mensaje = "Completar los campos para cambiar contraseña";
      } else if ($('#contrasenia_anterior').val() !== "" && $('#contrasenia_nueva').val() !== "" && $(
          '#repetir_contrasenia').val() === "") {
        mensaje = "Completar los campos para cambiar contraseña";
      } else if ($('#contrasenia_anterior').val() !== "" && $('#contrasenia_nueva').val() === "" && $(
          '#repetir_contrasenia').val() !== "") {
        mensaje = "Completar los campos para cambiar contraseña";
      } else if ($('#contrasenia_anterior').val() === "" && $('#contrasenia_nueva').val() !== "" && $(
          '#repetir_contrasenia').val() !== "") {
        mensaje = "Completar los campos para cambiar contraseña";
      } else {
        if ($('#contrasenia_nueva').val() !== $('#repetir_contrasenia').val()) {
          mensaje = "La nueva contraseña no coincide con la confirmación";
        } else {
          alert = "success"
          const formData = new FormData();
          formData.append('id', $('#detalleCuenta input[name="id"]').val());
          formData.append('_token', $('#detalleCuenta input[name="_token"]').val());
          formData.append('name', $('#detalleCuenta input[name="name"]').val());
          formData.append('lastname', $('#detalleCuenta input[name="lastname"]').val());
          formData.append('email', $('#detalleCuenta input[name="email"]').val());
          formData.append('password', $('#detalleCuenta input[name="password"]').val());
          formData.append('newpassword', $('#detalleCuenta input[name="newpassword"]').val());
          formData.append('confirmnewpassword', $('#detalleCuenta input[name="confirmnewpassword"]')
            .val());

          $.ajax({

            url: "{{ route('actualizarPerfil') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            success: function(success) {


              Swal.fire({
                position: "center",
                icon: success.alert,
                title: success.message,
                showConfirmButton: true,

              });


              // window.location.href = window.location.href;


            },
            error: function(error) {
              console.log(error)
            }

          })

        }
      }

      if (alert == "error") {
        Swal.fire({
          position: "center",
          icon: alert,
          title: mensaje,
          showConfirmButton: true,

        });
      } else if (alert == "success") {

      }

    });
  </script>
@stop

@stop
