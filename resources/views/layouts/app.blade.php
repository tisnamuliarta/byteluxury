<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('imgs/icon.png') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="api-base-url" content="{{ url('/') }}"/>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body
    @if(!Auth::check())
    style="
        height: 100vh;
        background: url('{{ asset('/imgs/bg.jpg') }}') !important;
        background-repeat: no-repeat;
        background-size: cover!important;
    "
    @endif
>
@if(Auth::check())
    @include('layouts.sidebar')
    <div class="main-content">
        @include('layouts.topnav')
        @include('layouts.titlenav')
        <div class="container-fluid mt--6">
            <div id="app">
                @yield('content')
            </div>
            @include('layouts.footer')
        </div>
    </div>
@else
    <div class="main-content">
        <div class="container" id="app">
            @yield('content')
        </div>
    </div>
@endif
<!-- Scripts -->
<script src="{{ asset(mix('js/app.js')) }}" defer></script>
@yield('script')
</body>
</html>
