@if(Auth::user()->isAn('admin'))
    @includeIf('layouts.partials.menu.admin')
@endif

@if(Auth::user()->isA('customer'))
    @includeIf('layouts.partials.menu.customer')
@endif

@if(Auth::user()->isA('designer'))
    @includeIf('layouts.partials.menu.designer')
@endif

<div class="card">
    <div class="card-header">
        Contact
    </div>
    <div class="card-body">
        <p>
            Liever telefonisch contact?
        </p>


    </div>
</div>

@yield('rails-menu')
