<x-app-layout>
  <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <section class="py-4 border-b border-slate-100 dark:border-slate-700">
      <a href="{{ route('logos.create') }}"
        class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded text-sm">Agregar</a>
    </section>


    <div
      class="col-span-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">


      <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100 text-2xl tracking-tight">Estadísticas</h2>
      </header>
      <div class="p-3">

        <!-- Table -->
        <div class="overflow-x-auto">

          <table id="tabladatos" class="display text-lg" style="width:100%">
            <thead>
              <tr>
                <th class="w-16">Orden</th>
                {{-- <th class="w-32">Imagen</th>
                <th class="w-32">Fondo</th> --}}
                <th>Titulo</th>
                <th>Descripción</th>
                {{-- <th class="w-32">Destacar</th> --}}
                <th class="w-32">Visible</th>
                <th class="w-32">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($logos as $logo)
                <tr>
                  <td>{{$logo->order}}</td>
                  {{-- <td class="dark:bg-slate-800"><img class="w-20 object-contain mx-auto" src="{{ asset($logo->url_image) }}" onerror="this.onerror=null;this.src='{{ asset('images/img/noimagen.jpg') }}';"/></td>
                  <td class="dark:bg-slate-800"><img class="w-20 object-contain mx-auto" src="{{ asset($logo->url_image2) }}" onerror="this.onerror=null;this.src='{{ asset('images/img/noimagen.jpg') }}';"/></td> --}}
                  <td class="dark:bg-slate-800">{{ $logo->title }}</td>
                  <td class="dark:bg-slate-800">{{ $logo->description }}</td>
                   {{-- <td class="">
                    <form method="POST" action="">
                      @csrf
                      <input type="checkbox" id="hs-basic-usage"
                        class="check_d btn_swithc relative w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent 
                                            rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none 
                                            checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-gray-800 dark:border-gray-700 
                                            dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600 before:inline-block before:size-6
                                            before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow 
                                            before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-gray-400 dark:checked:before:bg-blue-200"
                        id='{{ 'd_' . $logo->id }}' data-field='destacar' data-idService='{{ $logo->id }}'
                        data-titleService='{{ $logo->title }}' {{ $logo->destacar == 1 ? 'checked' : '' }}>
                      <label for="{{ 'v_' . $logo->id }}"></label>
                    </form>



                  </td> --}}
                  <td class="">
                    <form method="POST" action="">
                      @csrf
                      <input type="checkbox" id="hs-basic-usage"
                        class="check_v btn_swithc relative w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent 
                                            rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none 
                                            checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-gray-800 dark:border-gray-700 
                                            dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600 before:inline-block before:size-6
                                            before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow 
                                            before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-gray-400 dark:checked:before:bg-blue-200"
                        id='{{ 'v_' . $logo->id }}' data-field='visible' data-idService='{{ $logo->id }}'
                        data-titleService='{{ $logo->title }}' {{ $logo->visible == 1 ? 'checked' : '' }}>
                      <label for="{{ 'v_' . $logo->id }}"></label>
                    </form>
                  </td>
                  
                  <td class="flex flex-row justify-center items-center gap-5">
                    <a href="{{ route('logos.edit', $logo->id) }}"
                      class="bg-yellow-400 px-3 py-2 rounded text-white  "><i
                        class="fa-regular fa-pen-to-square"></i></a>

                    <form action=" " method="POST">
                      @csrf
                      <a data-idService='{{ $logo->id }} ' href=""
                        class="btn_delete bg-red-600 px-3 py-2 rounded text-white cursor-pointer"><i
                          class="fa-regular fa-trash-can"></i></a>
                      <!-- <a href="" class="bg-red-600 p-2 rounded text-white"><i class="fa-regular fa-trash-can"></i></a> -->
                    </form>
                  </td>
                </tr>
              @endforeach



            </tbody>
            <tfoot>
              <tr>
                <th>Orden</th>
                {{-- <th>Imagen</th>
                <th class="w-32">Fondo</th> --}}
                <th>Titulo</th>
                <th>Descripción</th>
                {{-- <th class="w-32">Destacar</th> --}}
                <th class="w-32">Visible</th>
                
                <th>Acciones</th>
              </tr>
            </tfoot>
          </table>

        </div>
      </div>
    </div>

  </div>

  <script>
    $('document').ready(function() {

      let table = new DataTable('#tabladatos', {
            ordering:false,
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            layout: {
                topStart: 'buttons'
            },
            language: {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                
                 "sProcessing":"Procesando...",
            },
            buttons:[ 
           
            {
                extend:    'excelHtml5',
                text:      '<i class="fas fa-file-excel"></i> ',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success',
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fas fa-file-pdf"></i> ',
                titleAttr: 'Exportar a PDF',
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fas fa-file-csv"></i> ',
                titleAttr: 'Imprimir',
                className: 'btn btn-info',
            },
            {
                extend:    'print',
                text:      '<i class="fa fa-print"></i> ',
                titleAttr: 'Imprimir',
                className: 'btn btn-info',
            },
            {
                extend:    'copy',
                text:      '<i class="fas fa-copy"></i> ',
                titleAttr: 'Copiar',
                className: 'btn btn-success',
            },
        ]
        });

      $(".btn_delete").on("click", function(e) {
        e.preventDefault()

        let id = $(this).attr('data-idService');

        Swal.fire({
          title: "Seguro que deseas eliminar?",
          text: "Vas a eliminar un Logo",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Si, borrar!",
          cancelButtonText: "Cancelar"
        }).then((result) => {
          if (result.isConfirmed) {

            $.ajax({

              url: '{{ route('logos.deleteLogo') }}',
              method: 'POST',
              data: {
                _token: $('input[name="_token"]').val(),
                id: id,

              }

            }).done(function(res) {

              Swal.fire({
                title: res.message,
                icon: "success"
              });

              location.reload();

            })


          }
        });

      });


      $("#tabladatos").on("change", ".btn_swithc", function() {

        var status = 0;
        var id = $(this).attr('data-idService');
        let contenedor = $(this);
        var titleService = $(this).attr('data-titleService');
        var field = $(this).attr('data-field');

        if ($(this).is(':checked')) {
          status = 1;

        } else {
          status = 0;
        }



        $.ajax({
          url: "{{ route('logos.updateVisible') }}",
          method: 'POST',
          data: {
            _token: $('input[name="_token"]').val(),
            status: status,
            id: id,
            field: field,
          },
          success: function(response) {
            Swal.fire({
              position: "top-end",
              icon: "success",
              title: titleService + " a sido modificado",
              showConfirmButton: false,
              timer: 1500

            });

            if (response.cantidad >= 100000) {


              Swal.fire({
                position: "top-center",
                icon: "success",
                title: "Ya no puedes destacar más",
                showConfirmButton: false,
                timer: 2000

              });

              // Deshabilitar todos los checkboxes con la clase .check_d
              $('.check_d:not(:checked)').prop('disabled', true);



            } else {

              // Habilitar todos los checkboxes con la clase .check_d
              $('.check_d').prop('disabled', false);
            }

          },
          error: function(response) {

            Swal.close();
            Swal.fire({
              title: response.responseJSON.message,
              icon: "error",
            });

            contenedor[0].checked = !contenedor[0].checked;

          }
        })



      });



    })
  </script>

</x-app-layout>
