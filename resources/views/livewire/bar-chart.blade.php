<div class="row">
    <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4>Persentase</h4>
            </div>
            <div class="card-body">
                <canvas id="myChart4" style="min-height: 300px"
                    data-active="{{ $kasus->active_case / $kasus->total_case * 100 }}"
                    data-recovered="{{ $kasus->total_recovered / $kasus->total_case * 100 }}"
                    data-death="{{ $kasus->total_death / $kasus->total_case * 100 }}"
                ></canvas>
            </div>
        </div>
    </div>
</div>


@push('javascript')
<script>
    var ctx = document.getElementById("myChart4").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'pie',
  data: {
    datasets: [{
      data: [
        $('#myChart4').data('active'),
        $('#myChart4').data('recovered'),
        $('#myChart4').data('death'),
      ],
      backgroundColor: [
        '#6777ef',
        '#63ed7a',
        '#fc544b',
      ],
      label: 'Dataset 1'
    }],
    labels: [
      'Dirawat',
      'Sembuh',
      'Meninggal'
    ],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    legend: {
      position: 'bottom',
    },
  }
});
</script>
@endpush