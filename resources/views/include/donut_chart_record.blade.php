<div class="col-md-6">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Persentase</h3>
        </div>
        <div class="card-body">
            <div class="chart">
                {!! $donat->container() !!}
            </div>
        </div>
        <!-- /.card-body -->
    </div>
</div>

@push('scripts')
{!! $donat->script() !!}
@endpush