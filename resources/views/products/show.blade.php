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
                | <a href="{{ route('teams.show', $product->user->bedrijf()->first() ) }}">{{ $product->user->bedrijf()->first()->name }}</a> - <a href="{{ route('users.show', $product->user) }}">{{ $product->user->name }}</a>
            @endif
        </span>
        </div>
        <div class="card-body">
            <product-view :id="{{ $product->id }}"></product-view>
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

@section('rails-menu')
    @can('insert-product-hours')
        <div class="card my-2">
            <div class="card-header">
                Uren toevoegen
            </div>
            <div class="card-body">
                <add-hours-view :user_id="{{ \Auth::user()->id }}" :product_id="{{ $product->id }}"></add-hours-view>
            </div>
        </div>
    @endcan
@endsection
