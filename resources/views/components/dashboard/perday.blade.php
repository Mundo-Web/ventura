<div class="col-span-full w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
  <div class="flex justify-between">
    <div>
      <h5 id="total-sales" class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">32.4k</h5>
      <p class="text-base font-normal text-gray-500 dark:text-gray-400">total en ventas de este mes</p>
    </div>
  </div>
  <canvas id="line-chart" class="w-full"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  moment.locale('es');
  const salesPerDay = @json($data);

  function getDatesInMonth(year, month) {
    let dates = [];
    let daysInMonth = moment(`${year}-${month}`, "YYYY-MM").daysInMonth();
    for (let day = 1; day <= daysInMonth; day++) {
      dates.push({
        date: moment(`${year}-${month}-${day}`, "YYYY-MM-DD").format("YYYY-MM-DD"),
        pretty: moment(`${year}-${month}-${day}`, "YYYY-MM-DD").format("dddd DD")
      });
    }
    return dates;
  }

  const salesPerDayFinal = getDatesInMonth(moment().year(), moment().month() + 1).map(x => {
    const found = salesPerDay.find(s => s.day == x.date)
    return {
      ...x,
      total: Number(found?.total),
      quantity: found?.quantity ?? 0
    }
  })

  const salesPerDayTotal = salesPerDayFinal.reduce((total, x) => total += (x.total || 0), 0).toLocaleString('en-US', {
    maximumFractionDigits: 2,
    minimumFractionDigits: 2
  })
  $('#total-sales').text(`$ ${salesPerDayTotal}`)

  const skipped = (ctx, value) => ctx.p0.skip || ctx.p1.skip ? value : undefined;
  const down = (ctx, value) => ctx.p0.parsed.y > ctx.p1.parsed.y ? value : undefined;

  const salesPerDayTotals = salesPerDayFinal.map(x => x.total)
  if (!salesPerDayTotals[0]) salesPerDayTotals[0] = 0
  if (!salesPerDayTotals[salesPerDayTotals.length - 1]) salesPerDayTotals[salesPerDayTotals.length - 1] = 0

  new Chart(document.getElementById('line-chart'), {
    type: 'bar',
    data: {
      labels: salesPerDayFinal.map(x => x.pretty),
      datasets: [{
        label: `Ventas de ${moment().format('MMMM YYYY')}`,
        data: salesPerDayTotals,
        borderColor: '#10c469',
        backgroundColor: 'rgb(99 102 241)',
        segment: {
          borderColor: ctx => skipped(ctx, '#ced4da') || down(ctx, '#ff5b5b'),
          borderDash: ctx => skipped(ctx, [6, 6]),
        },
        spanGaps: true
      }]
    },
    options: {
      fill: false,
      interaction: {
        intersect: false
      },
      radius: 0,
    }
  })
</script>
