@php
  $isAdmin = isset($isAdmin) ? 1 : 0;
@endphp

<link href="/js/dxdatagrid/css/dx.light.css?v=06d3ebc8-645c-4d80-a600-c9652743c425" rel="stylesheet" type="text/css"
  id="dg-default-stylesheet" />
<script src="/js/dxdatagrid/js/dx.all.js"></script>
<script src="/js/dxdatagrid/js/localization/dx.messages.es.js"></script>
<script src="/js/moment/min/moment.min.js"></script>

<div id="gridContainer"></div>

<script>
  const salesDataGrid = $('#gridContainer').dxDataGrid({
    language: "es",
    dataSource: {
      load: async (params) => {
        const res = await fetch("{{ route('sales.paginate') }}{{ !$isAdmin ? '?data=mine' : '' }}", {
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
    // searchPanel: {
    //   visible: true
    // },
    // headerFilter: {
    //   visible: true,
    //   search: {
    //     enabled: true
    //   }
    // },
    // height: 'calc(100vh - 185px)',
    rowAlternationEnabled: true,
    showBorders: true,
    // filterRow: {
    //   visible: true,
    //   applyFilter: "auto"
    // },
    // filterBuilderPopup: {
    //   visible: false,
    //   position: {
    //     of: window,
    //     at: 'top',
    //     my: 'top',
    //     offset: {
    //       y: 10
    //     },
    //   },
    // },
    paging: {
      pageSize: 5,
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
    // columnChooser: {
    //   title: 'Mostrar/Ocultar columnas',
    //   enabled: true,
    //   mode: 'select',
    //   search: {
    //     enabled: true
    //   }
    // },
    columns: [{
        dataField: 'created_at',
        caption: 'ORDEN',
        cellTemplate: (container, {
          data
        }) => {
          container.addClass('!px-3 !py-2')
          const div = $('<div>')
          const orderContainer = $('<a>', {
            class: 'block text-sm font-medium truncate dark:text-black text-blue-500 cursor-pointer max-w-max',
            text: `#${data.code}`
          })
          if (data.confirmation_client) {
            orderContainer.append(`<span class="ms-1 inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1 rounded-full dark:bg-green-900 dark:text-green-300 w-max" title="El cliente confirmo la recepcion del producto" tippy>
              <i class="fa fa-solid fa-user-check"></i>  
            </span>`)
          }
          if (data.confirmation_user) {
            orderContainer.append(`<span class="ms-1 inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1 rounded-full dark:bg-green-900 dark:text-green-300 w-max" title="El vendedor confirmo la entrega del producto" tippy>
              <i class="fa fa-solid fa-check-to-slot"></i>  
            </span>`)
          }
          tippy('[tippy]', {
            arrow: true
          })
          orderContainer.on('click', () => openSaleModal(data))
          // const addressContainer = $('<p>', {
          //   class: 'text-sm text-gray-500 dark:text-gray-400',
          //   text: data.address_description ?
          //     `${data.address_department}, ${data.address_province}, ${data.address_district} - ${data.address_street} #${data.address_number}` :
          //     'Recojo en tienda'
          // })
          const dateContainer = $('<p>', {
            class: 'text-xs text-gray-400',
            text: moment(data.created_at).format('YYYY-MM-DD HH:mm:ss')
          }).prepend(isAdmin ? `<span class="me-1 text-gray-800">${data.name} ${data.lastname}</span>` : '')
          div.append(orderContainer)
          // div.append(addressContainer)
          div.append(dateContainer)

          container.html(div)
        }
      },
      {
        dataField: 'status.name',
        caption: 'ESTADO',
        cellTemplate: (container, {
          data
        }) => {
          container.addClass('!px-3 !py-2 !text-center')
          container.css('vertical-align', 'middle')
          container.html(
            `<span style="background-color:${data.status?.color}" class="inline-flex items-center text-white text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-[${data.status?.color ?? '#000000'}22] dark:text-[${data.status?.color ?? '#000000'}bb] w-max">${data.status?.name ?? 'Sin estado'}</span>`
          )
        }
      },
      {
        dataField: 'total',
        caption: 'MONTO',
        cellTemplate: (container, {
          data
        }) => {
          container.addClass('!px-3 !py-2 !text-center')
          container.css('vertical-align', 'middle')

          const isFree = !Boolean(Number(data.address_price))
          const div = $('<div>', {
            class: 'text-center'
          })
          const priceContainer = $('<span>', {
            class: 'block w-max mx-auto',
            text: `$ ${data.total}`
          })
          const envioContainer = $('<span>', {
              class: `inline-flex items-center ${ isFree ? 'bg-green-100' : 'bg-blue-100'} ${ isFree ? 'text-green-800' : 'text-blue-800'} text-xs font-medium px-2.5 py-0.5 rounded-full dark:${ isFree ? 'bg-green-900' : 'bg-blue-900'} dark:${ isFree ? 'text-green-300' : 'text-blue-300'} w-max`
            })
            .append(
              `<span class="/w-2 h-2 me-1 ${isFree ? 'bg-green-500' : 'bg-blue-500' } rounded-full"></span>`)
            .append(isFree ? 'Envio gratis' : `$ ${Number(data.address_price).toFixed(2)}`)

          div.append(priceContainer)
          div.append(envioContainer)

          container.html(div)
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
