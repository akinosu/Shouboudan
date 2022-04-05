<DOCTYPE HTML>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')｜消防団.com</title>
        <meta name="description" itemprop="description" content="@yield('description')">
        <meta name="keywords" itemprop="keywords" content="@yield('keywords')">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Styles -->
        <link href="{{ asset('css/all.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="styleSheet">
        @yield('pageCss')

        <!-- Scripts -->
        <script src="{{ asset('js/all.js') }}"></script>
        @yield('pageScript')

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    </head>

    <body>
        @yield('header')
        @yield('content')
        @yield('footer')
    </body>

    </html>