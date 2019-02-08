@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <span>
            {{ $product->name }}
            @if($product->user->bedrijf()->exists())
                | {{ $product->user->bedrijf()->first()->name }}
            @endif
        </span>
    </div>
    <div class="card-body">
        <p class="card-text">
            Naam: {{ $product->name }}
        </p>
        <p class="card-text">
            Omschrijving: {{ $product->description }}
        </p>
        <p class="card-text">
            Soort: {{ $product->soort }}
        </p>
        <p class="card-text">
            Formaat: {{ $product->format }}
        </p>
        <p class="card-text">
            Deadline: {{ $product->deadline }}
        </p>
        <p class="card-text">
            Status: {{ $product->status }}
        </p>
        <p class="card-text">
            <a href="{{ route('products.image', $product) }}" class="disabled" aria-disabled="true">Voorbeeld</a>
        </p>
        <p class="card-text"><small class="text-muted">Laatste aanpassing op: {{ $product->updated_at }}</small></p>
    </div>
    @can('update')
        <div class="card-footer">
            <a href="{{ route('products.edit', $product) }}" class="card-link">Bewerken</a>
        </div>
    @endcan
    @can('update-status')
        <div class="card-footer">
            <form action="{{ route('products.update', $product) }}" method="post">
                @csrf
                @method('PUT')
                <modify-product-status></modify-product-status>
            </form>
        </div>
    @endcan
</div>
@endsection
