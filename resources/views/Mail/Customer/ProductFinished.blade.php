@component('mail::message')
Beste {{ $product->user->name }},

De aanvraag ‘{{ $product->name }}’ is afgerond. Indien het om een gedrukt product gaat is deze nu in bestelling bij de drukkerij.


Met vriendelijke groet,


Team Doede Jaarsma communicatie
@endcomponent
