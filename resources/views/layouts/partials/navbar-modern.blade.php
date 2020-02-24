<header class="header">
	<div class="container mx-auto flex">
		<a href="{{ url('/') }}" class="navbar-brand">
			<img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name', 'Doede Jaarsma communcatie') }}" class="logo">
		</a>

		<nav class="md:flex md:flex-auto">
			<!-- Nav start -->
			<div></div>

			<!-- Nav end -->
			<div class="ml-auto flex nav-bar">
			@guest
				<a class="nav-item" href="{{ route('login') }}">
					{{ __('Login') }}
				</a>
			@else
				@if(Route::has('register') && \Auth::user()->can('create', \App\User::class))
					<a href="{{ route('register') }}" class="nav-item">
						{{ __('Register') }}
					</a>
				@endif
				<a href="{{ route('users.show', \Auth::user()) }}" class="nav-item">
					Profiel
				</a>
				<a href="{{ route('logout') }}"
				   onclick="event.preventDefault();
				   document.getElementById('logout-form').submit()"
				>
					{{ __('Logout') }}
				</a>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					@csrf
				</form>
			@endguest
			</div>
		</nav>
	</div>
</header>
