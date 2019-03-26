@extends('layouts.app')

@push('head')
    <script defer src="https://use.fontawesome.com/releases/v5.8.0/js/all.js" integrity="sha384-ukiibbYjFS/1dhODSWD+PrZ6+CGCgf8VbyUH7bQQNUulL+2r59uGYToovytTf4Xm" crossorigin="anonymous"></script>
@endpush

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        <span class="mr-auto">
            Producten
        </span>
        @can('download')
            <a class="btn btn-outline-primary" href="{{ route('download.product.all') }}" style="-webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%;"><i class="fas fa-download"></i></a>
        @endcan
        @can('create', '\App\Models\Product')
            <a class="btn ml-2 btn-outline-primary" href="{{ route('products.create') }}" style="-webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%;"><i class="fas fa-plus"></i></a>
        @endcan
    </div>
    <div class="card-body">
        <products-over-view></products-over-view>
{{--        <table class="table">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th scope="col">#</th>--}}
{{--                <th scope="col">Naam</th>--}}
{{--                <th scope="col">Aanvraag door</th>--}}
{{--                <th scope="col">Status</th>--}}
{{--                <th scope="col">Deadline</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @foreach($products as $product)--}}
{{--                <tr>--}}
{{--                    <th scope="row">--}}
{{--                        <a href="{{ route('products.show', $product) }}">--}}
{{--                            {{ $product->id }}--}}
{{--                        </a>--}}
{{--                    </th>--}}
{{--                    <td>--}}
{{--                        <a href="{{ route('products.show', $product) }}">--}}
{{--                            {{ $product->name }}--}}
{{--                        </a>--}}
{{--                    </td>--}}
{{--                    <td title="{{ $product->user->bedrijf()->first()->name }}">--}}
{{--                        {{ $product->user->name }}--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        {{ $product->status }}--}}
{{--                    </td>--}}
{{--                    <td class="text-muted">--}}
{{--                        {{ $product->deadline }}--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}
    </div>
</div>
@endsection
