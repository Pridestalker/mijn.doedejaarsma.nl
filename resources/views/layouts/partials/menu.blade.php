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
            Liever telefonisch contact?
        </p>
        <div class="media">
            <img src="{{asset('img/tomgracht.jpg')}}" class="mr-3" alt="...">
            <div class="media-body">
                <h5 class="mt-0">Tom Govers</h5>
                <p>
                    <a href="mailto:tom@doedejaarsma.nl">tom@doedejaarsma.nl</a>
                </p>
            </div>
        </div>

    </div>
</div>

@yield('rails-menu')
