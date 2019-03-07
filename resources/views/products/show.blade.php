@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
<div class="card">
    <div class="card-header">
        <span>
            {{ $product->name }}
            @if($product->user->bedrijf()->exists())
                | {{ $product->user->bedrijf()->first()->name }} - {{ $product->user->name }}
            @endif
        </span>
    </div>
    <div class="card-body">
        <p class="card-text">
            Naam: {{ $product->name }}
        </p>
        @isset($product->description)
            <p class="card-text">
                Omschrijving: {{ $product->description }}
            </p>
        @endisset
        <p class="card-text">
            Soort: {{ $product->soort }}
        </p>
        @isset($product->format)
            <p class="card-text">
                Formaat: {{ $product->format }}
            </p>
        @endisset
        <p class="card-text">
            Deadline: {{ $product->deadline }}
        </p>
        <p class="card-text">
            Status: {{ $product->status }}
        </p>
        @isset($product->options)
            @php
                $_options = json_decode($product->options);
            @endphp
            <p class="card-text">
                Oplage: {{ $_options->oplage }}
            </p>
            <p class="card-text">
                Papier: {{ $_options->papier }}
            </p>
            <p class="card-text">
                Gewicht: {{ $_options->gewicht }}
            </p>
            <p class="card-text">
                Afleveradres: {{ $_options->afleveradres }}
            </p>
        @endisset
        @isset($product->factuur)
            <p class="card-text">
                Factuurnummer: {{ $product->factuur }}
            </p>
        @endisset
        <p class="card-text">
            <a href="{{ route('products.image', $product) }}" class="disabled" aria-disabled="true">Voorbeeld</a>
        </p>
        <p class="card-text"><small class="text-muted">Laatste aanpassing op: {{ $product->updated_at }}</small></p>
    </div>
    @can('delete', '\App\Models\Product')
        <div class="card-footer">
            <form action="{{ route('products.destroy', $product) }}" method="post">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-primary">Verwijderen</button>
            </form>
        </div>
    @endcan
    @can('update', '\App\Models\Product')
        <div class="card-footer">
            <a href="#" class="card-link disabled" aria-disabled="true">Bewerken</a>
        </div>
    @endcan
    @can('update-status', '\App\Models\Product')
        <div class="card-footer">
            <form action="{{ route('products.update', $product) }}" method="post">
                @csrf
                @method('PUT')
                <modify-product-status></modify-product-status>
            </form>
        </div>
    @endcan
    @can('update-factuur', '\App\Models\Product')
        <div class="card-footer">
            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')
                <modify-product-factuur></modify-product-factuur>
            </form>
        </div>
    @endcan
</div>
@endsection
