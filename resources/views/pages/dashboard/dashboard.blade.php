<x-app-layout>
  <script src="/js/moment/min/moment.min.js"></script>
  <script src="/js/moment/locale/es.js"></script>
  <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <x-dashboard.welcome-banner />

    <div class="grid grid-cols-12 gap-6">

      <!-- Line chart (Acme Plus) -->
      <x-dashboard.simplecard title="Reporte de ventas" sub-title="{{ $salesLastMonth->month }}"
        amount="$ {{ number_format($salesLastMonth ? $salesLastMonth->total : 0, 2, '.', ',') }}"
        badge="{{ $salesLastMonth ? $salesLastMonth->quantity : 0 }} ventas" />
      <x-dashboard.simplecard title="Reporte de ventas" sub-title="{{ $salesThisMonth->month }}"
        amount="$ {{ number_format($salesThisMonth->total, 2, '.', ',')  }}" badge="{{ $salesThisMonth->quantity }} ventas" />
      <x-dashboard.simplecard title="Pedidos por atender" amount="{{$pendingSales}}" >
        <x-slot name="subTitle">
          <a href="{{route('pedidos.index')}}" class="hover:underline">
            Ver pedidos
            <i class="fa fa-arrow-right"></i>
          </a>
        </x-slot>
      </x-dashboard.simplecard>
      <x-dashboard.simplecard title="Pedidos atendidos" sub-title="" amount="{{$servedSales}}" >
        <x-slot name="subTitle">
          <a href="{{route('pedidos.index')}}" class="hover:underline">
            Ver pedidos
            <i class="fa fa-arrow-right"></i>
          </a>
        </x-slot>
      </x-dashboard.simplecard>

      <x-dashboard.perday :data="$salesPerDay"/>
      
      {{-- <!-- Bar chart (Direct vs Indirect) -->
      <x-dashboard.dashboard-card-04 />

      <!-- Line chart (Real Time Value) -->
      <x-dashboard.dashboard-card-05 /> --}}

      

      <!-- Table (Top Channels) -->
      <x-dashboard.top10 title="Top 10 productos mas vendidos" :data="$topProducts" />

      <!-- Doughnut chart (Top Countries) -->
      <x-dashboard.topdistritos :data="$topDistricts"/>

      {{-- <!-- Line chart (Sales Over Time)  -->
      <x-dashboard.dashboard-card-08 />

      <!-- Stacked bar chart (Sales VS Refunds) -->
      <x-dashboard.dashboard-card-09 />

      <!-- Card (Customers)  -->
      <x-dashboard.dashboard-card-10 />

      <!-- Card (Reasons for Refunds)   -->
      <x-dashboard.dashboard-card-11 />

      <!-- Card (Recent Activity) -->
      <x-dashboard.dashboard-card-12 />

      <!-- Card (Income/Expenses) -->
      <x-dashboard.dashboard-card-13 />  --}}

    </div>

  </div>
</x-app-layout>
