<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<noscript>
    <div class="alert alert-danger">
        Je hebt javascript nodig om de site goed te laten werken.
        Als je problemen ervaart kan javascript aanzetten een oplossing bieden.
    </div>
</noscript>
    <div id="app">
        @includeIf('layouts.partials.navbar')

        <main class="py-4" id="app">
            <div class="container">
                <div class="row justify-content-center">
                    @auth()
                        <div class="col-md-4">
                            @includeIf('layouts.partials.menu')
                        </div>
                    @endauth
                    <div class="col-md-8">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>


@if(session('clearStorage'))
    <script>
        localStorage.removeItem('product_soort');
        localStorage.removeItem('product_omschrijving');
        localStorage.removeItem('product_name');
        localStorage.removeItem('product_kostenplaats');
        localStorage.removeItem('product_format');
        localStorage.removeItem('product_deadline');
        localStorage.removeItem('product_oplage');
        localStorage.removeItem('product_gewicht');
        localStorage.removeItem('product_afleveradres');
    </script>
@endif
</body>
</html>
