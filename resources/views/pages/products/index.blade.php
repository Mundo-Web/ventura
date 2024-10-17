<x-app-layout>
  <link href="/js/dxdatagrid/css/dx.light.css?v=06d3ebc8-645c-4d80-a600-c9652743c425" rel="stylesheet" type="text/css"
    id="dg-default-stylesheet" />
  <script src="/js/dxdatagrid/js/dx.all.js"></script>
  <script src="/js/dxdatagrid/js/localization/dx.messages.es.js"></script>
  <script src="/js/moment/min/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

  {{-- <style>
    @media (prefers-color-scheme: dark) {
      .dark\:even\:bg-gray-900\/50:nth-child(even) {
        background-color: transparent !important;
        border-top: 1px solid rgb(55 65 81 / 0.25);
        border-bottom: 1px solid rgb(55 65 81 / 0.25);
      }
    }
  </style> --}}
  <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <section class="py-4 border-b border-slate-100 dark:border-slate-700">
      <a id="sincronizar" href="{{ route('products.synchronization') }}"
        class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded text-sm">
        Sincronizar departamentos
      </a>
    </section>

<script>
  
  $('#sincronizar').on('click', function(event) {
      event.preventDefault();
      console.log('Sincronizando departamentos...');

      $.ajax({
          url: "{{ route('products.synchronization') }}",
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}',

          },
          success: function() {
              // Mostrar mensaje de éxito usando SweetAlert
              Swal.fire({
                  title: 'Departamentos sincronizados exitosamente',
                  icon: 'success',
              });
          },
          error: function(xhr) {
              // Mostrar mensaje de error usando SweetAlert
              Swal.fire({
                  title: 'Error',
                  text: 'Ocurrió un error inesperado.',
                  icon: 'error',
              });
          }
      });
  });

</script>

    <div
      class="col-span-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">


      <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <h2 class="font-semibold text-slate-800 dark:text-slate-100 text-2xl tracking-tight">Productos </h2>
      </header>
      <div class="p-3">

        <!-- Table -->
        <div class="overflow-x-auto">
          {{-- 
          <table id="tabladatos" class="display text-lg" style="width:100%">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Descuento</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Destacar</th>
                <th>Recomendar</th>
                <th>Visible</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($products as $item)
                <tr>
                  <td>{{ $item->producto }} @if ($item->color)
                      - {{ $item->color }}
                    @endif
                  </td>
                  <td>{{ $item->precio }}</td>
                  <td>{{ $item->descuento }}</td>
                  <td>{{ $item->stock }}</td>
                  <td class="px-3 py-2"><img class="bg-[#f2f2f2] w-20 h-20 object-cover object-center"
                      src="{{ asset($item->imagen) }}" alt=""></td>
                  <td>
                    <form method="POST" action="">
                      @csrf
                      <input type="checkbox" id="hs-basic-usage"
                        class="check_v btn_swithc relative w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent 
                              rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none 
                              checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-gray-800 dark:border-gray-700 
                              dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600 before:inline-block before:size-6
                              before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow 
                              before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-gray-400 dark:checked:before:bg-blue-200"
                        id='{{ 'v_' . $item->id }}' data-field='destacar' data-idService='{{ $item->id }}'
                        data-titleService='{{ $item->producto }}' {{ $item->destacar == 1 ? 'checked' : '' }}>
                      <label for="{{ 'v_' . $item->id }}"></label>
                    </form>



                  </td>
                  <td>
                    <form method="POST" action="">
                      @csrf
                      <input type="checkbox" id="hs-basic-usage"
                        class="check_v btn_swithc relative w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent 
                              rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none 
                              checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-gray-800 dark:border-gray-700 
                              dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600 before:inline-block before:size-6
                              before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow 
                              before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-gray-400 dark:checked:before:bg-blue-200"
                        id='{{ 'v_' . $item->id }}' data-field='recomendar' data-idService='{{ $item->id }}'
                        data-titleService='{{ $item->producto }}' {{ $item->recomendar == 1 ? 'checked' : '' }}>
                      <label for="{{ 'v_' . $item->id }}"></label>
                    </form>



                  </td>


                  <td>
                    <form method="POST" action="">
                      @csrf
                      <input type="checkbox" id="switch_visible"
                        class="check_v btn_swithc relative w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent 
                              rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none 
                              checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-gray-800 dark:border-gray-700 
                              dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600 before:inline-block before:size-6
                              before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow 
                              before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-gray-400 dark:checked:before:bg-blue-200"
                        id='{{ 'v_' . $item->id }}' data-field='visible' data-idService='{{ $item->id }}'
                        data-titleService='{{ $item->producto }}' {{ $item->visible == 1 ? 'checked' : '' }}>
                      <label for="{{ 'v_' . $item->id }}"></label>
                    </form>



                  </td>

                  <td>
                    <div class="flex justify-center items-center gap-2 text-center sm:text-right h-full w-full">
                      <a href="{{ route('products.edit', $item->id) }}"
                        class="bg-yellow-400 px-3 py-2 rounded text-white  "><i
                          class="fa-regular fa-pen-to-square"></i></a>

                      <form action="" method="POST">
                        @csrf
                        <a data-idService='{{ $item->id }}'
                          class="btn_delete bg-red-600 px-3 py-2 rounded text-white cursor-pointer"><i
                            class="fa-regular fa-trash-can"></i></a>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach

            </tbody>
            <tfoot>
              <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Descuento</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Destacar</th>
                <th>Recomendar</th>
                <th>Visible</th>
                <th>Acciones</th>
              </tr>
            </tfoot>
          </table> --}}

          <div id="gridContainer"></div>

        </div>
      </div>
    </div>

  </div>



</x-app-layout>

<script>
  const salesDataGrid = $('#gridContainer').dxDataGrid({
    language: "es",
    dataSource: {
      load: async (params) => {
        const res = await fetch("{{ route('products.paginate') }}", {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'XSRF-TOKEN': decodeURIComponent(Cookies.get('XSRF-TOKEN'))
          },
          body: JSON.stringify({
            _token: $('[name="_token"]').val(),
            ...params
          })
        })
        const data = await res.json()
        return data
      },
    },
    onToolbarPreparing: (e) => {
      const items = e.toolbarOptions.items;
      items.unshift({
        widget: 'dxButton',
        location: 'after',
        options: {
          icon: 'revert',
          hint: 'REFRESCAR TABLA',
          onClick: () => {
            salesDataGrid.refresh()
          }
        }
      });
    },
    remoteOperations: true,
    columnResizingMode: "widget",
    allowColumnResizing: true,
    allowColumnReordering: true,
    columnAutoWidth: true,
    scrollbars: 'auto',
    // filterPanel: {
    //   visible: true
    // },
    searchPanel: {
      visible: true
    },
    // headerFilter: {
    //   visible: true,
    //   search: {
    //     enabled: true
    //   }
    // },
    // height: 'calc(100vh - 185px)',
    rowAlternationEnabled: true,
    showBorders: true,
    paging: {
      pageSize: 10,
    },
    pager: {
      visible: true,
      allowedPageSizes: [5, 10, 25, 50, 100],
      showPageSizeSelector: true,
      showInfo: true,
      showNavigationButtons: true,
    },
    allowFiltering: true,
    scrolling: {
      mode: 'standard',
      useNative: true,
      preloadEnabled: true,
      rowRenderingMode: 'standard'
    },
    columns: [{
        dataField: 'producto',
        caption: 'PRODUCTO',
        width: '40%'
      },
      {
        dataField: 'precio',
        caption: 'PRECIO'
      },
      {
        dataField: 'descuento',
        caption: 'DESCUENTO'
      },
      {
        dataField: 'stock',
        caption: 'STOCK'
      },
      {
        caption: 'ESTADO',
        cellTemplate: (container, {
          data
        }) => {
          container.addClass('!px-3 !py-2 !text-center')
          container.css('vertical-align', 'middle')
          container.html(
            `<img class="bg-[#f2f2f2] w-16 h-10 object-cover object-center rounded-sm" src="/${data.imagen}" alt=""></td>`
          )
        }
      },
      {
        dataField: 'destacar',
        caption: 'DESTACAR',
        cellTemplate: (container, {
          data
        }) => {
          container.html(`<form method="POST" action="">
            @csrf
            <input type="checkbox" id="hs-basic-usage"
              class="check_v btn_swithc relative w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent 
                    rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none 
                    checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-gray-800 dark:border-gray-700 
                    dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600 before:inline-block before:size-6
                    before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow 
                    before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-gray-400 dark:checked:before:bg-blue-200"
              id='d_${data.id}' data-field='destacar' data-idService='${data.id}'
              data-titleService='${data.producto}' ${data.destacar ? 'checked': ''}>
            <label for="d_${data.id}"></label>
          </form>`)
        }
      },
      /* {
        dataField: 'recomendar',
        caption: 'RECOMENDAR',
        cellTemplate: (container, {
          data
        }) => {
          container.html(`<form method="POST" action="">
            @csrf
            <input type="checkbox" id="hs-basic-usage"
              class="check_v btn_swithc relative w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent 
                    rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none 
                    checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-gray-800 dark:border-gray-700 
                    dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600 before:inline-block before:size-6
                    before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow 
                    before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-gray-400 dark:checked:before:bg-blue-200"
              id='r_${data.id}' data-field='recomendar' data-idService='${data.id}'
              data-titleService='${data.producto}' ${data.recomendar ? 'checked': ''}>
            <label for="r_${data.id}"></label>
          </form>`)
        }
      }, */
      {
        dataField: 'visible',
        caption: 'VISIBLE',
        cellTemplate: (container, {
          data
        }) => {
          container.html(`<form method="POST" action="">
            @csrf
            <input type="checkbox" id="switch_visible"
              class="check_v btn_swithc relative w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent 
                    rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-transparent disabled:opacity-50 disabled:pointer-events-none 
                    checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-gray-800 dark:border-gray-700 
                    dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600 before:inline-block before:size-6
                    before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow 
                    before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-gray-400 dark:checked:before:bg-blue-200"
              id='v_${data.id}' data-field='visible' data-idService='${data.id}'
              data-titleService='${data.producto}' ${data.visible ? 'checked' : ''}>
            <label for="v_${data.id}"></label>
          </form>`)
        }
      },
      {
        caption: 'ACCIONES',
        cellTemplate: (container, {
          data
        }) => {
          container.addClass('!px-3 !py-2 !text-center')
          container.css('vertical-align', 'middle')
          container.html(`<a href="/admin/products/${data.id}/edit"
            class="inline-block bg-yellow-400 px-3 py-2 rounded text-white  ">
            <i class="fa-regular fa-pen-to-square"></i>
          </a>
          <form action="" method="POST" class="inline-block">
            @csrf
            <a data-idService='${data.id}'
              class="btn_delete bg-red-600 px-3 py-2 rounded text-white cursor-pointer">
              <i class="fa-regular fa-trash-can"></i>
            </a>
          </form>`)
        }
      }
    ],
    onContentReady: (...props) => {
      tippy('.tippy-here', {
        arrow: true,
        animation: 'scale'
      })
    }
  }).dxDataGrid('instance')
</script>

<script>
  $('document').ready(function() {

    new DataTable('#tabladatos', {
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

        "sProcessing": "Procesando...",
      },
      buttons: [

        {
          extend: 'excelHtml5',
          text: '<i class="fas fa-file-excel"></i> ',
          titleAttr: 'Exportar a Excel',
          className: 'btn btn-success',
        },
        {
          extend: 'pdfHtml5',
          text: '<i class="fas fa-file-pdf"></i> ',
          titleAttr: 'Exportar a PDF',
        },
        {
          extend: 'csvHtml5',
          text: '<i class="fas fa-file-csv"></i> ',
          titleAttr: 'Imprimir',
          className: 'btn btn-info',
        },
        {
          extend: 'print',
          text: '<i class="fa fa-print"></i> ',
          titleAttr: 'Imprimir',
          className: 'btn btn-info',
        },
        {
          extend: 'copy',
          text: '<i class="fas fa-copy"></i> ',
          titleAttr: 'Copiar',
          className: 'btn btn-success',
        },
      ]
    });

    $(document).on("change", ".btn_swithc", function() {



      let status = 0;
      let id = $(this).attr('data-idService');
      let titleService = $(this).attr('data-titleService');
      let field = $(this).attr('data-field');

      if ($(this).is(':checked')) {
        status = 1;
      } else {
        status = 0;
      }

      console.log(titleService)

      $.ajax({
        url: "{{ route('products.updateVisible') }}",
        method: 'POST',
        data: {
          _token: $('input[name="_token"]').val(),
          status: status,
          id: id,
          field: field,
          titleService
        }
      }).done(function(res) {

        Swal.fire({
          position: "top-end",
          icon: "success",
          title: titleService + " a sido modificado",
          showConfirmButton: false,
          timer: 1500

        });

      })
    });

    $(document).on("click", ".btn_delete", function(e) {
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

            url: `{{ route('products.borrar') }}`,
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

  })
</script>
