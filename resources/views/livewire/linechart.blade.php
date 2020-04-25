<div class="row">
  <div class="col-12 col-sm-12 col-lg-12">
      <div class="card">
          <div class="card-header">
              <h4>Time Line</h4>
          </div>
          <div class="card-body">
              <canvas id="myChart3" height="400"
                data-label="{{ json_encode($label->toArray()) }}"
                data-confirmed="{{ json_encode($confirmed->toArray()) }}"
                data-active="{{ json_encode($active->toArray()) }}"
                data-new-case="{{ json_encode($newCase->toArray()) }}"
                data-recovered="{{ json_encode($recovered->toArray()) }}"
                data-death="{{ json_encode($death->toArray()) }}"
              ></canvas>
          </div>
      </div>
  </div>
</div>

@push('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<script>
    var label = $('#myChart3').data('label');
    var confirmed = $('#myChart3').data('confirmed');
    var active = $('#myChart3').data('active');
    var newCase = $('#myChart3').data('newCase');
    var recovered = $('#myChart3').data('recovered');
    var death = $('#myChart3').data('death');

    var ctx = document.getElementById("myChart3").getContext('2d');
    var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels:  label,
    datasets: [{
      label: 'Total Kasus',
      data: confirmed,
      backgroundColor: 'transparent',
      borderColor: 'rgba(102, 119, 239, 1)',
      borderWidth: 2.5,
      pointRadius: 2,
    },
    {
      label: 'Dalam Perawatan',
      data: active,
      backgroundColor: 'transparent',
      borderColor: 'rgba(255, 163, 38, 1)',
      borderWidth: 2.5,
      pointRadius: 2,
    },
    {
      label: 'Kasus Baru',
      data: newCase,
      backgroundColor: 'transparent',
      borderColor: 'rgba(58, 186, 244, 1)',
      borderWidth: 2.5,
      pointRadius: 2,
    },
    {
      label: 'Sembuh',
      data: recovered,
      backgroundColor: 'transparent',
      borderColor: 'rgba(71, 195, 99, 1)',
      borderWidth: 2.5,
      pointRadius: 2,
    },
    {
      label: 'Meninggal',
      data: death,
      backgroundColor: 'transparent',
      borderColor: 'rgba(252, 84, 75, 1)',
      borderWidth: 2.5,
      pointRadius: 2,
    },
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    legend: {
      display: true
    },
    scales: {
      yAxes: [{
        gridLines: {
          drawBorder: false,
          color: '#f2f2f2',
        },
        ticks: {
          beginAtZero: true,
        }
      }],
      xAxes: [{
        ticks: {
          display: true
        },
        gridLines: {
          display: false
        },
        type: 'time',
        time: {
            tooltipFormat: 'll'
        }
      }]
    },
  }
});
</script>
@endpush