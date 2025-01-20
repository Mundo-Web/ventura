@extends('components.public.matrix', ['pagina' => ' '])

@section('css_importados')

@stop
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
  .fixedWhastapp {
    right: 2vw !important;
  }
</style>

@section('content')
  <section class="w-11/12 mx-auto font-FixelText_Regular mt-10 lg:mt-12">
    @if ($errors->has('g-recaptcha-response'))
      <span class="help-block">
        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
      </span>
    @endif
    <h2 class="col-span-4 font-Homie_Bold font-bold text-4xl leading-none md:leading-tight text-center pt-3">Libro de Reclamaciones</h2>
    <form class="flex flex-col gap-5" id="formLibroReclamo" action="" method="POST" enctype='multipart/form-data'>
      <div class=" my-16 grid grid-cols-1  lg:grid-cols-4 gap-5 justify-center items-center">
        @csrf

        <h2 class="col-span-4 font-semibold font-Homie_Bold text-[24px] leading-none md:leading-tight">Identificación del Consumidor
        </h2>

        <div class="flex flex-col col-span-4 lg:col-span-2 gap-2">
          <label for="fullname" class="font-medium text-[12px] text-[#6C7275]">Nombre</label>
          <input id="fullname" type="text" placeholder="Nombre Completo" required name="fullname"
            class="w-full py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" />
        </div>


        <div class="flex flex-col col-span-4 lg:col-span-1 gap-2">
          <label for="type_document" class="font-medium text-[12px] text-[#6C7275]">Tipo de documento</label>
          <select id="type_document" required name="type_document"
            class="w-full py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]">
            <option>RUC</option>
            <option>C.E</option>
            <option>PASAPORTE</option>
            <option>DNI</option>
          </select>
        </div>


        <div class="flex flex-col col-span-4 lg:col-span-1 gap-2">
          <label for="number_document" class="font-medium text-[12px] text-[#6C7275]">Numero de indentidad</label>
          <input id="number_document" type="text" placeholder="Numero de indentidad" required name="number_document"
            class="w-full py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" />
        </div>

        <div class="flex flex-col col-span-4 lg:col-span-2 gap-2">
          <label for="cellphone" class="font-medium text-[12px] text-[#6C7275]">Celular</label>
          <input id="cellphone" type="text" placeholder="Numero celular" required name="cellphone"
            class="w-full py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" />
        </div>

        <div class="flex flex-col col-span-4 lg:col-span-2 gap-2">
          <label for="email" class="font-medium text-[12px] text-[#6C7275]">Correo
            Electrónico</label>
          <input type="email" placeholder="hola@gmail.com" required name="email" id="email"
            class="w-full py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl" />
        </div>

        <div class="flex flex-col col-span-4 lg:col-span-2 gap-2">
          <label for="department" class="font-medium text-[12px] text-[#6C7275]">Departamento</label>
          <select id="selectDepartamento" placeholder="Departamento" required name="department"
            class="w-full py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]">
            <option value="">Seleccionar departamento </option>
            @foreach ($departamentofiltro as $item)
              <option value="{{ $item->id }}">{{ $item->description }}</option>
            @endforeach
          </select>
        </div>

        <div class="flex flex-col col-span-4 lg:col-span-1 gap-2">
          <label for="province" class="font-medium text-[12px] text-[#6C7275]">Provincia</label>
          <select id="selectProvincia" type="text" placeholder="Provincia" required name="province"
            class="w-full py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]">
            <option value="">Seleccionar provincia </option>
          </select>
        </div>

        <div class="flex flex-col col-span-4 lg:col-span-1 gap-2">
          <label for="district" class="font-medium text-[12px] text-[#6C7275]">Distrito</label>
          <select id="selectDistrito" type="text" placeholder="Distrito" required name="district"
            class="w-full py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]">
            <option value="">Seleccionar distrito </option>
          </select>
        </div>

        <div class="flex flex-col col-span-4 gap-2">
          <label for="address" class="font-medium text-[12px] text-[#6C7275]">Direccion</label>
          <input id="address" type="text" placeholder="Direccion" required name="address"
            class="w-full py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" />
        </div>



        <h2 class="col-span-4 font-semibold font-Homie_Bold text-[24px] leading-none md:leading-tight">Identificación del bien
          contratado</h2>

        <div class="flex flex-col col-span-4 gap-2">
          <label for="typeitem" class="font-medium text-[12px] text-[#6C7275]">¿Fue un producto o
            Servicio?</label>
          <select id="typeitem" required name="typeitem"
            class="w-full py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]">
            <option>Producto</option>
            <option>Servicio</option>
          </select>
        </div>

        <div class="flex flex-col col-span-4 lg:col-span-2 gap-2">
          <label for="amounttotal" class="font-medium text-[12px] text-[#6C7275]">Monto reclamado</label>
          <input id="amounttotal" type="text" placeholder="Monto total reclamado" required name="amounttotal"
            class="w-full py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" />
        </div>

        {{-- <div class="flex flex-col col-span-4 lg:col-span-1 gap-2">
                    <label for="category_product_service" class="font-medium text-[12px] text-[#6C7275]">Tipo de
                        bien</label>
                    <select id="category_product_service" type="text" required name="category_product_service"
                        class="w-full py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]">
                        <option>Producto</option>
                        <option>Servicio</option>
                    </select>
                </div> --}}

        <div class="flex flex-col col-span-4 lg:col-span-2 gap-2">
          <label for="description" class="font-medium text-[12px] text-[#6C7275]">Descripcion de
            producto</label>
          <input id="description" type="text" placeholder="Nombre de producto y/o servicios, codigo(opcional)"
            required name="description"
            class="w-full py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" />
        </div>

        <h2 class="col-span-4 font-Homie_Bold font-semibold text-[24px] leading-none md:leading-tight">Detalle del reclamo del
          pedido del consumidor</h2>


        <div class="flex flex-col col-span-4 gap-2">
          <label for="type_claim" class="font-medium text-[12px] text-[#6C7275]">¿Es un reclamo o queja?</label>
          <select id="type_claim" type="text" required name="type_claim"
            class="w-full py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]">
            <option>Reclamo</option>
            <option>Queja</option>
          </select>
        </div>


        <div class="flex flex-col col-span-4 lg:col-span-2 gap-2">
          <label for="date_incident" class="font-medium text-[12px] text-[#6C7275]">Fecha de ocurrencia</label>
          <input id="date_incident" type="date" placeholder="Provincia" required name="date_incident"
            class="w-full py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" />
        </div>

        <div class="flex flex-col col-span-4 lg:col-span-2 gap-2">
          <label for="address_incident" class="font-medium text-[12px] text-[#6C7275]">Numero de Pedido</label>
          <input id="address_incident" type="text" placeholder="Numero de pedido: #95825548" required
            name="address_incident"
            class="w-full py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" />
        </div>

        <div class="flex flex-col col-span-4 gap-2">
          <label for="detail_incident" class="font-medium text-[12px] text-[#6C7275]">Detalle de reclamo o
            queja</label>
          <textarea name="detail_incident" id="detail_incident" cols="30" rows="3"
            class="border-gray-200 border-[1.5px] rounded-xl focus:outline-none" placeholder="Detalle de reclamo" required></textarea>
        </div>


        <div class="flex flex-row col-span-4 gap-2 ">
          <input id="termsandconditions" type="checkbox" required class="border-2 rounded-sm w-5 h-5" />
          <label for="termsandconditions" class="font-medium text-sm text-[#6C7275]">Estoy de acuerdo con los
            <a target="_blank" class="font-bold" href="{{ route('terms_condition') }} ">terminos y
              condiciones</a></label>

        </div>
        {{-- <div class="flex flex-col col-span-4 gap-2">
                    <label for="archivo" class="font-medium text-[12px] text-[#6C7275]">Adjuntar archivos
                        (opcional)</label>
                    <input id="archivo" type="file"  name="archivo"
                        class="w-full py-3 px-4 focus:outline-none placeholder-gray-400 font-normal text-[16px] border-[1.5px] border-gray-200 rounded-xl text-[#6C7275]" />
                </div> --}}


        <div class="flex flex-row col-span-4 gap-2 ">
          {!! NoCaptcha::renderJs() !!}
          {!! NoCaptcha::display() !!}
        </div>

        <div class="flex flex-row col-span-2 gap-2 ">
          <input type="submit" value="Enviar a libro de reclamaciones" id="btnAjax"
            class="col-span-4 text-white bg-[#006258] py-3 rounded-2xl cursor-pointer border-2 font-semibold text-[16px] text-center border-none w-full md:w-auto px-10 inline-block" />
        </div>

      </div>
    </form>
  </section>

@section('scripts_importados')

  <script>
    // function alerta(message) {
    //     Swal.fire({
    //         title: message,
    //         icon: "error",
    //     });
    // }

    $(document).ready(function() {

    })

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

    $('#formLibroReclamo').submit(function(event) {

      event.preventDefault();
      let formData = new FormData(this);
      // formData.append('g-recaptcha-response', token);

      // console.log(formData);

      if (!validarEmail($('#email').val())) {
        return;
      };


      /* console.log(formDataArray); */
      $.ajax({
        url: '{{ route('guardarFormReclamo') }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
          Swal.fire({
            title: 'Enviando Por favor Espere...',
            html: `
              <div style="display: flex; justify-content: center; align-items: center; height: 100%; ">
                <div role="status" class='text-center p-2'>
                  
                
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    
                  
                </div>
              </div>
            `,
            allowOutsideClick: false,
            onBeforeOpen: () => {
              Swal.showLoading();
            }
          });
        },
        success: function(response) {
          Swal.close();
          // $('#formLibroReclamo')[0].reset();
          Swal.fire({
            title: response.message,
            icon: "success",
          });

        },
        error: function(error) {
          Swal.close();
          if (error.responseJSON && error.responseJSON.errors) {
            const errors = error.responseJSON.errors;
            const keys = Object.keys(errors);
            let errorMessages = '';

            keys.forEach(key => {
              errorMessages += `<p>${errors[key][0]}</p>`;
            });

            Swal.fire({
              title: 'Fallo al enviar el mensaje',
              html: errorMessages,
              icon: 'warning',
            });
          } else {
            Swal.fire({
              title: 'Error',
              text: 'Ocurrió un error inesperado',
              icon: 'error',
            });
          }
        }
      });
    })
  </script>


  <script>
    $(document).ready(function() {
      $('#selectDepartamento').change(function() {
        var departmentId = $(this).val();
        if (departmentId) {
          $.ajax({
            url: '/obtenerProvincia/' + departmentId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
              $('#selectProvincia').prop('disabled', false).empty().append(
                '<option value="">Selecciona una provincia</option>');
              $.each(data, function(key, value) {
                $('#selectProvincia').append('<option value="' + value
                  .id +
                  '">' + value.description + '</option>');
              });
              $('#selectDistrito').prop('disabled', true).empty().append(
                '<option value="">Selecciona un distrito</option>');
            }
          });
        } else {
          $('#selectProvincia').prop('disabled', true).empty().append(
            '<option value="">Selecciona una provincia</option>');
          $('#selectDistrito').prop('disabled', true).empty().append(
            '<option value="">Selecciona un distrito</option>');
        }
      });

      $('#selectProvincia').change(function() {
        var provinceId = $(this).val();
        if (provinceId) {
          $.ajax({
            url: '/obtenerDistritos/' + provinceId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
              $('#selectDistrito').prop('disabled', false).empty().append(
                '<option value="">Selecciona un distrito</option>');
              $.each(data, function(key, value) {
                $('#selectDistrito').append('<option value="' + value
                  .id +
                  '">' + value.description + '</option>');
              });
            }
          });
        } else {
          $('#selectDistrito').prop('disabled', true).empty().append(
            '<option value="">Selecciona un distrito</option>');
        }
      });
    });
  </script>
@stop

@stop
