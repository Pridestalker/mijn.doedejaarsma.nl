@if(Auth::user()->isAn('admin'))
    @includeIf('layouts.partials.menu.admin')
@endif

@if(Auth::user()->isA('customer'))
    @includeIf('layouts.partials.menu.customer')
@endif

@if(Auth::user()->isA('designer'))
    @includeIf('layouts.partials.menu.designer')
@endif

@yield('rails-menu')
