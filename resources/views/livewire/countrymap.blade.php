<div class="row">
    <div class="col-12 col-sm-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4>Indonesia Map</h4>
            </div>
            <p></p>
            <div class="card-body" style="min-height: 400px;">
                <div id="visitorMap3" data-json="{{ json_encode($data) }}"></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4>Data Provinsi</h4>
            </div>
            <div class="card-body" id="top-5-scroll" style="min-height: 415px;">
                @foreach($data as $province)
                <div class="mb-4">
                    <div class="text-small float-right font-weight-bold text-muted">{{ $province['positif'] }}</div>
                    <div class="font-weight-bold mb-1">{{ $province['provinsi'] }}</div>
                    <div class="progress" data-height="3">
                        <div class="progress-bar" role="progressbar" data-width="{{ $province['percentage'] }}%" aria-valuenow="80"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

    @push('stylesheet')
    <style>
        .jqvmap-label,
        .jqvmap-pin {
            pointer-events: none
        }

        .jqvmap-label {
            position: absolute;
            display: none;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            background: #292929;
            color: #fff;
            font-family: sans-serif, Verdana;
            font-size: smaller;
            padding: 3px
        }

        .jqvmap-zoomin,
        .jqvmap-zoomout {
            position: absolute;
            left: 10px;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            background: #000;
            padding: 3px;
            color: #fff;
            width: 10px;
            height: 10px;
            cursor: pointer;
            line-height: 10px;
            text-align: center
        }

        .jqvmap-zoomin {
            top: 10px
        }

        .jqvmap-zoomout {
            top: 30px
        }

        .jqvmap-region {
            cursor: pointer
        }

        .jqvmap-ajax_response {
            width: 100%;
            height: 500px
        }

    </style>
    <style>
        /* 1.16 jQVmap */
        .jqvmap-circle {
            display: inline-block;
            width: 13px;
            height: 13px;
            background-color: #fff;
            border: 3px solid #6777ef;
            border-radius: 50%;
        }

        .jqvmap-label {
            z-index: 889;
        }

        .jqvmap-zoomin,
        .jqvmap-zoomout {
            height: auto;
            width: auto;
        }

    </style>
    @endpush

    @push('javascript')
    <script src="{{ asset('module/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('module/jquery.vmap.indonesia.js') }}"></script>
    <script>
        var lokasi = $('#visitorMap3').data('json');

        var myObj = {};
        var tagged = {};

        $.each(lokasi, function (i, value) {
            myObj[value.path] = {
                tag: '<div class="jqvmap-circle"></div>',
                confirmed: value.positif,
                recovered: value.sembuh,
                death: value.meninggal,
            };

            tagged[value.path] = '<div class="jqvmap-circle"></div>';
        });

        if($("#top-5-scroll").length) {
          $("#top-5-scroll").css({
            height: 315
          }).niceScroll();
        }

        $('#visitorMap3').vectorMap({
            map: 'indonesia_id',
            backgroundColor: '#ffffff',
            borderColor: '#f2f2f2',
            borderOpacity: .8,
            borderWidth: 1,
            hoverColor: '#000',
            hoverOpacity: .8,
            color: '#ddd',
            normalizeFunction: 'linear',
            selectedRegions: false,
            showTooltip: true,
            pins: tagged,
            onLabelShow: function (event, label, code) {
                var countryName = label[0].innerHTML;

                var html = ['<table>',
                    '<tr>',
                    '<td><strong>' + countryName + '</strong></td>',
                    '<td></td>',
                    '</tr>',
                    '<tr>',
                    '<td>Kasus</td>',
                    '<td>' + myObj[code].confirmed + '</td>',
                    '</tr>',
                    '<tr>',
                    '<td>Sembuh</td>',
                    '<td>' + myObj[code].recovered + '</td>',
                    '</tr>',
                    '<tr>',
                    '<td>Meninggal</td>',
                    '<td>' + myObj[code].death + '</td>',
                    '</tr>',
                    '</table>'
                ].join("");
                label[0].innerHTML = html;
            }
        });

    </script>
    @endpush
