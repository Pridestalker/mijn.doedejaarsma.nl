@component('mail::message')
{{ $product->user->name }} heeft een nieuwe productaanvraag gedaan via ons systeem.

@component('mail::panel')
Overzicht:


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


Met vriendelijke groet,


Team Doede Jaarsma communicatie

@endcomponent
