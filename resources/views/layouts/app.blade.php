<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">

</head>
<body id="page-top">
    <div id="app">
        <div id="wrapper">
            @auth
                @include('layouts.sidebar')
            @endauth
            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">
                <!-- Main Content -->
                <div id="content">
                @auth
                    @include('layouts.topbar')
                @endauth
                <!-- Begin Page Content -->
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- End of Main Content -->
                @include('layouts.footer')
            </div>
            <!-- End of Content Wrapper -->
        </div>
    </div>
</body>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

</html>

