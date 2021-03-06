@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

<div class="card">
    <div class="card-header">
        Aanvraag doen
    </div>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            @csrf
            <create-product-view></create-product-view>
        </div>
        @can('set-product-user')
            <div class="card-footer">
                <div class="form-group">
                    <label for="user_id">Gebruiker</label>
                    <select name="user_id" id="user_id" class="custom-select">
                        <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                        @foreach( \App\User::whereIs('customer')->active()->get() as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @else
            <input type="hidden" name="user_id" value="{{ \Auth::user()->id }}">
        @endcan
    </form>
</div>
@endsection
