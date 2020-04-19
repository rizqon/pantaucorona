<div class="row">
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-gradient-info">
                <div class="inner">
                    <h3>{{ $kasus->total_case }}
                        <sup style="font-size: 15px; top: -15px"><i class="fas fa-arrow-up"></i> {{ $kasus->new_case }}</sup>
                    </h3>
                    <p>Total Kasus</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hospital-alt"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h3>{{ $kasus->total_recovered }}
                        <sup style="font-size: 15px; top: -15px"><i class="fas fa-arrow-up"></i> {{ $kasus->new_recovered }}</sup>
                    </h3>

                    <p>Total Sembuh</p>
                </div>
                <div class="icon">
                    <i class="fas fa-heart"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-gradient-purple">
                <div class="inner">
                    <h3>{{ $kasus->active_case }}
                    @php
                    $yesterday = \App\Kasus::whereDate('created_at', \Carbon\Carbon::yesterday())->latest()->first();
                    $today = \App\Kasus::whereDate('created_at', \Carbon\Carbon::today())->latest()->first();
                    @endphp
                    @if($yesterday)
                        @if($yesterday->active_case < $today->active_case)
                            <sup style="font-size: 15px; top: -15px"><i class="fas fa-arrow-up"></i> {{ $today->active_case - $yesterday->active_case }}</sup>
                        @elseif($yesterday->active_case > $today->active_case)
                            <sup style="font-size: 15px; top: -15px"><i class="fas fa-arrow-down"></i> {{ $yesterday->active_case - $today->active_case }}</sup>
                        @endif
                    @endif
                    </h3>
                    <p>Dalam Perawatan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-ambulance"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-gradient-danger">
                <div class="inner">
                    <h3>{{ $kasus->total_death }}
                        <sup style="font-size: 15px; top: -15px"><i class="fas fa-arrow-up"></i> {{ $kasus->new_death }}</sup>
                    </h3>

                    <p>Total Meninggal</p>
                </div>
                <div class="icon">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
    </div>
