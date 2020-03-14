<div class="col-md-6">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Persentase</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                        class="fas fa-times"></i></button>
            </div>
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