@extends('layouts.skeleton')

@section('title', 'Informasi Data Terkait COVID19')

@section('app')
<div class="main-wrapper container">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        @include('partials.topnav')
      </nav>
      <nav class="navbar navbar-secondary navbar-expand-lg">
        @include('partials.secondary-top-nav')
      </nav>

    <!-- Main Content -->
    <div class="main-content">
      @yield('content')
    </div>
    <footer class="main-footer">
      @include('partials.footer')
    </footer>
  </div>
@endsection
