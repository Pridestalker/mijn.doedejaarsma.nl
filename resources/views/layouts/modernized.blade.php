<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DJC_DTP') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script defer src="https://kit.fontawesome.com/18b24fd6e3.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600" rel="stylesheet" type="text/css">
    <!-- Styles -->

    @stack('head')
</head>
<body>
<noscript>
    <div class="alert alert-danger">
        Je hebt javascript nodig om de site goed te laten werken.
        Als je problemen ervaart kan javascript aanzetten een oplossing bieden.
    </div>
</noscript>
<div id="app">
    @yield('content')
</div>

<footer class="container is-flex">
    <small class="" style="margin-left: auto;">
        <a href='/docs/' class="text-muted">
            Versie: {{ config('app.version') }}
        </a>
    </small>
</footer>

<link rel="stylesheet" href="https://cdn.materialdesignicons.com/3.6.95/css/materialdesignicons.min.css">
</body>
</html>
