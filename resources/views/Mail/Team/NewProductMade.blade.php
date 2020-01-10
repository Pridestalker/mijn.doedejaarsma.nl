@component('mail::message')
{{ $product->user->name }} heeft een nieuwe productaanvraag gedaan via ons systeem.

@component('mail::panel')
Overzicht:


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


Met vriendelijke groet,


Team Doede Jaarsma communicatie

@endcomponent
