@extends('layout.master')


@section('last_update', $kasus->created_at->format('j F Y - H:i'))

@section('content')
<div class="container">
    @include('include.top_record')
    @include('include.bar_chart_record')
    
    <div class="row">
        @include('include.donut_chart_record')
        @include('include.news_stream')
    </div>
</div>
@endsection
