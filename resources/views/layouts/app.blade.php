<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    @yield('stylesheets')
</head>
<body>
    <div id="app">
        <x-sidebar />

        <main class="main-content pb-3 pt-6">
            <x-navbar />
            @section('header')
            <div class="header bg-primary pb-6 mt--3 mb-3">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center py-4">
                            <div class="col-lg-6 col-7">
                                <h6 class="h2 text-white d-inline-block mb-0">@yield('title')</h6>
                            </div>
                            <div class="col-lg-6 col-5 text-right">
                                @yield('header-buttons')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @show

            @if (session('status'))
            <div class="col-10 offset-1" style="z-index: 1000">
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            </div>
            @endif

            <div class="container-fluid mt--6">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('javascripts')
</body>
</html>
