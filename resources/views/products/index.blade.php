@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        Producten
        @can('create', '\App\Models\Product')
            <a class="btn ml-auto btn-outline-primary" href="{{ route('products.create') }}" style="-webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%;">+</a>
        @endcan
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Naam</th>
                <th scope="col">Aangemaakt op</th>
                <th scope="col">Laatste aanpassing op</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <th scope="row">
                        <a href="{{ route('products.show', $product) }}">
                            {{ $product->id }}
                        </a>
                    </th>
                    <td>
                        <a href="{{ route('products.show', $product) }}">
                            {{ $product->name }}
                        </a>
                    </td>
                    <td class="text-muted">
                        {{ $product->created_at }}
                    </td>
                    <td class="text-muted">
                        {{ $product->updated_at }}
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
