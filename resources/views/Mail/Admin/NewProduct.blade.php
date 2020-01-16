@component('mail::message')

Er is een nieuw product aangevraagd!

@component('mail::button', ['url' => route('products.index') . '#/single/' . $product->id])
Bekijken
@endcomponent

@component('mail::panel')
Het product is aangevraagd door:
{{ $product->user->name }} van {{ $product->user->bedrijf()->first()->name?? '' }}
@endcomponent

@component('mail::panel')
### Overzicht:


Naam: {{ $product->name }}


@isset($product->info->description)
Omschrijving: {{ $product->info->description }}


@endisset


@isset($product->info->format)
Formaat: {{ $product->info->format }}


@endisset
Deadline: {{ $product->order->deadline }}


Status: {{ $product->order->status }}


@isset($product->info->options->oplage)
Oplage: {{ $product->info->options->oplage }}


@endisset
@isset($product->info->options->papier)
Papier: {{ $product->info->options->papier }}


@endisset
@isset($product->info->options->gewicht)
Gewicht: {{ $product->info->options->gewicht }}


@endisset
@isset($product->info->options->afleveradres)
Afleveradres: {{ $product->info->options->afleveradres }}


@endisset
@endcomponent

@endcomponent
