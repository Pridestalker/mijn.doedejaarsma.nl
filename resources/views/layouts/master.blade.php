<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{ config('app.name', 'Mijn Doede Jaarsma communicatie') }}</title>

	<script src="{{ asset('js/manifest.js') }}"></script>
	<script src="{{ asset('js/vendor.js') }}"></script>
	<script src="{{ asset('js/app.js') }}"></script>
	<script defer src="https://kit.fontawesome.com/18b24fd6e3.js"></script>

	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,600" rel="stylesheet" type="text/css">

	<link rel="stylesheet" href="{{ asset('css/main.css', true) }}">
	@stack('head')
</head>
<body>
<noscript>
	<div class="alert alert-danger">
		Je hebt javascript nodig om de site goed te laten werken.
		Als je problemen ervaart kan javascript aanzetten een oplossing bieden.
	</div>
</noscript>
@includeFirst(['layouts.partials.navbar-modern', 'layouts.partials.navbar'])
<main class="container mx-auto flex">
	@auth()
		<div class="md:w-1/3">
			@includeIf('layouts.partials.menu')
		</div>
	@endauth
	<div class="md:w-2/3">
		@yield('content')
	</div>
</main>

<footer class="container mx-auto flex">
	<small class="ml-auto">
		<a href='/docs/' class="text-muted">
			Versie: {{ config('app.version') }}
		</a>
	</small>
</footer>

<link rel="stylesheet" href="https://cdn.materialdesignicons.com/3.6.95/css/materialdesignicons.min.css">

</body>
</html>
