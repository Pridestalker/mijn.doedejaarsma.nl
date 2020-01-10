@component('mail::message')
Beste {{ $product->user->name }},


Bedankt voor je aanvraag. Hierbij bevestigen wij de ontvangst van de opdracht.
Zodra onze vormgevers hiermee aan de slag gaan ontvang je een status update.


@component('mail::panel')
    Heb je aanvullend nog vragen/opmerkingen/foto’s die je met ons wilt delen? Reageer dan op deze e-mail. (Bestanden groter dan 10MB graag via WeTransfer)
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


Met vriendelijke groet,


Team Doede Jaarsma communicatie

@endcomponent
