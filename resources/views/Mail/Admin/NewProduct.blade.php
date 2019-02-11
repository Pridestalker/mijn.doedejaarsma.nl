@component('mail::message')

Er is een nieuw product aangevraagd!

@component('mail::button', ['url' => route('products.show', $product)])
Bekijken
@endcomponent

@component('mail::panel')
Het product is aangevraagd door:
{{ $product->user->name }} van {{ $product->user->bedrijf()->first()->name }}
@endcomponent

@endcomponent
