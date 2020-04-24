@extends('layouts.app')


@section('content')
<section class="section">
    <div class="section-body">
    @livewire('counter')
    @livewire('linechart')
    @livewire('countrymap')
    @livewire('bar-chart')
    </div>
</section>
@endsection