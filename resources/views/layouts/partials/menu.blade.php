@if(Auth::user()->isAn('admin'))
    @includeIf('layouts.partials.menu.admin')
@endif

@if(Auth::user()->isA('customer'))
    @includeIf('layouts.partials.menu.customer')
@endif

@if(Auth::user()->isA('designer'))
    @includeIf('layouts.partials.menu.designer')
@endif

<div class="card mt-4">
    <div class="card-header">
        Contact
    </div>
    <div class="card-body">
        <p>
            Kom je er niet helemaal uit? Neem dan contact met ons op
        </p>
        <div class="media">
            <img src="{{asset('img/tomgracht.jpg')}}" class="mr-3" alt="Tom Govers - Doede Jaarsma communicatie" width="80">
            <div class="media-body">
                <h5 class="mt-0">Tom Govers</h5>
                <p>
                    <a href="mailto:tom@doedejaarsma.nl">dtp@doedejaarsma.nl</a>
					<a href="tel:020-7852695">020-7852695</a>
                </p>
				<p>
				</p>
            </div>
        </div>

    </div>
</div>

@yield('rails-menu')
