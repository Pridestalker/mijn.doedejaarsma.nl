@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ $user->name }}
        </div>
        <div class="card-body">
            <div class="card-text">
                <p class="card-text">
                    Naam: {{ $user->name }}
                </p>
                <p class="card-text">
                    E-mail: {{ $user->email }}
                </p>
                <p class="card-text"><small class="text-muted">Laatste aanpassing op: {{ $user->updated_at }}</small></p>
            </div>
        </div>
        @can('update')
            <div class="card-footer">
                <a href="{{ route('users.edit', $user) }}" class="card-link">Bewerken</a>
            </div>
        @endcan
    </div>

    <div class="mt-3">
        @foreach($user->products()->where('status', 'aangevraagd')->get() as $product)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $product->status }}</h6>
                </div>
            </div>
        @endforeach
    </div>
@endsection
