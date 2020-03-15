<div class="row">
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Timeline</h3>
            </div>
            <div class="card-body">
                <div class="chart">
                    {!! $chart->container() !!}
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@push('scripts')
{!! $chart->script() !!}
@endpush
