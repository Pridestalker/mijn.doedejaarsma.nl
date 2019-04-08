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
    <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js" integrity="sha384-0pzryjIRos8mFBWMzSSZApWtPl/5++eIfzYmTgBBmXYdhvxPc+XcFEk+zJwDgWbP" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('head')
</head>
<body>
<noscript>
    <div class="alert alert-danger">
        Je hebt javascript nodig om de site goed te laten werken.
        Als je problemen ervaart kan javascript aanzetten een oplossing bieden.
    </div>
</noscript>
    <div>
        @includeIf('layouts.partials.navbar')

        <main class="py-4">
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

<footer class="container d-flex">
    <small class="text-muted ml-auto">
        <a href='/docs/' class="text-muted">
            Versie: {{ config('app.version') }}
        </a>
    </small>
</footer>
@impersonating
    <aside class="position-fixed bg-primary rounded-circle p-2" style="right: 3rem; bottom: 3rem; width: 3rem; height: 3rem; display: flex; align-items: center; justify-content: center;">
        <a href="{{ route('impersonate.leave') }}"><i class="fas fa-user-alt-slash text-white"></i> </a>
    </aside>
@endImpersonating
@includeIf('layouts.scripts.resetLocalStorage')
</body>
</html>
