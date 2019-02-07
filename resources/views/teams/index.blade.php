@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            Bedrijven
            @can('create', '\App\Models\Team')
                <a class="btn ml-auto btn-outline-primary" href="{{ route('teams.create') }}" style="-webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%;">+</a>
            @endcan
        </div>
        <div class="card-body">
            @foreach($teams as $team)
                <a href="{{ route('teams.show', $team) }}">
                    {{ $team->name }}
                </a>
            @endforeach
        </div>
    </div>
@endsection
