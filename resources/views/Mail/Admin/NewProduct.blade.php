@component('mail::message')

Er is een nieuw product aangevraagd!

@component('mail::button', ['url' => route('products.show', $product)])
Bekijken
@endcomponent

@component('mail::panel')
Het product is aangevraagd door:
{{ $product->user->name }} van {{ $product->user->bedrijf()->first()->name }}
@endcomponent

@component('mail::panel')
### Overzicht:


Naam: {{ $product->name }}


@isset($product->description)
Omschrijving: {{ $product->description }}


@endisset
Soort: {{ $product->soort }}


@isset($product->format)
Formaat: {{ $product->format }}


@endisset
Deadline: {{ $product->deadline }}


Status: {{ $product->status }}


@isset($product->options->oplage)
Oplage: {{ $product->options->oplage }}


@endisset
@isset($product->options->papier)
Papier: {{ $product->options->papier }}


@endisset
@isset($product->options->gewicht)
Gewicht: {{ $product->options->gewicht }}


@endisset
@isset($product->options->afleveradres)
Afleveradres: {{ $product->options->afleveradres }}


@endisset
@endcomponent

@endcomponent
