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
