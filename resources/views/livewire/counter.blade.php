<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fas fa-hospital-alt"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Kasus</h4>
                </div>
                <div class="card-body">
                    {{ $kasus->total_case }}
                    <sup style="font-size: 12px;"><i class="fas fa-arrow-up"></i> {{ $kasus->new_case }}</sup>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-heart"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Pasien Sembuh</h4>
                </div>
                <div class="card-body">
                    {{ $kasus->total_recovered }}
                    <sup style="font-size: 12px;"><i class="fas fa-arrow-up"></i> {{ $kasus->new_recovered }}</sup>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fas fa-ambulance"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Dalam Perawatan</h4>
                </div>
                <div class="card-body">
                    {{ $kasus->active_case }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="fas fa-heartbeat"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Meninggal</h4>
                </div>
                <div class="card-body">
                    {{ $kasus->total_death }}
                    <sup style="font-size: 12px;"><i class="fas fa-arrow-up"></i> {{ $kasus->new_death }}</sup>
                </div>
            </div>
        </div>
    </div>
</div>
