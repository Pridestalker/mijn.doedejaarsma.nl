@component('mail::message')
Beste {{ $product->user->name }},


Onze vormgevers zijn gestart met de aanvraag ‘{{ $product->name }}’. Zodra een eerste concept klaar is wordt dit gemaild.

Met vriendelijke groet,


Team Doede Jaarsma communicatie
@endcomponent
