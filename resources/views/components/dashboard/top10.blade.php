<div
  class="col-span-full xl:col-span-8 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
  <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700 flex justify-between">
    <h2 class="font-semibold text-slate-800 dark:text-slate-100">{{ $title }}</h2>
    <label class="inline-flex items-center cursor-pointer">
      <input id="orderBy" type="checkbox" value="" class="sr-only peer">
      <span class="me-3 text-sm font-medium text-gray-900 dark:text-gray-300">Ingresos</span>
      <div
        class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
      </div>
      <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Vendidos</span>
    </label>
  </header>
  <div class="p-3">
    <div class="overflow-x-auto max-h-[320px] overflow-y-auto">
      <table class="table-auto w-full dark:text-slate-500">
        <thead
          class="text-xs uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50 rounded-sm">
          <tr>
            <th class="p-2">
              <div class="font-semibold text-left">Producto</div>
            </th>
            <th class="p-2">
              <div class="font-semibold text-center">Clientes</div>
            </th>
            <th class="p-2">
              <div class="font-semibold text-center">Ingresos</div>
            </th>
            <th class="p-2">
              <div class="font-semibold text-center">Vendidos</div>
            </th>
          </tr>
        </thead>
        <tbody id="topProducts" class="text-sm font-medium divide-y divide-slate-100 dark:divide-slate-700">
          @foreach ($data as $item)
            <tr>
              <td class="p-2">
                <div class="flex items-center">
                  <img class="object-center object-cover rounded-md me-2" src="{{ asset($item->image) }}"
                    alt="{{ $item->name }}" width="36" height="36">
                  <div class="text-slate-800 dark:text-slate-100">{{ $item->name }}
                    @if ($item->color)
                      - {{ $item->color }}
                    @endif
                  </div>
                </div>
              </td>
              <td class="p-2">
                <div class="text-center">{{ $item->total_customers }}</div>
              </td>
              <td class="p-2">
                <div class="text-center text-emerald-500">$ {{ number_format($item->total_price, 2, '.', ',') }}</div>
              </td>
              <td class="p-2">
                <div class="text-center">{{ $item->total_quantity }}</div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>
</div>

<script>
  $('#orderBy').on('change', function() {
    const checked = this.checked
    fetch(`/api/dashboard/top-products/${checked ? 'total_quantity' : 'total_price'}`)
      .then(res => res.json())
      .then(data => {
        const rows = data ?? []
        $('#topProducts').empty()
        rows.forEach(row => {
          $('#topProducts').append(`<tr>
            <td class="p-2">
              <div class="flex items-center">
                <img class="object-center object-cover rounded-md me-2" src="/${row.image}"
                  alt="${row.name}" width="36" height="36">
                <div class="text-slate-800 dark:text-slate-100">${row.name}
                  ${row.color ? `- ${row.color}`: ''}
                </div>
              </div>
            </td>
            <td class="p-2">
              <div class="text-center">${row.total_customers}</div>
            </td>
            <td class="p-2">
              <div class="text-center text-emerald-500">$ ${row.total_price}</div>
            </td>
            <td class="p-2">
              <div class="text-center">${row.total_quantity}</div>
            </td>
          </tr>`)
        })
      })
  })
</script>
