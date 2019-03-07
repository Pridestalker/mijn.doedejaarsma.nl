@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        {{ $team->name }}
    </div>
    <div class="card-body">
        <div class="card-text">
            <p class="card-text">
                Naam: {{ $team->name }}
            </p>
            <p class="card-text">
                E-mail: {{ $team->email }}
            </p>
            <p class="card-text"><small class="text-muted">Laatste aanpassing op: {{ $team->updated_at }}</small></p>
        </div>
    </div>
    @can('update')
        <div class="card-footer">
            <a href="{{ route('teams.edit', $team) }}" class="card-link">Bewerken</a>
        </div>
    @endcan
</div>
<div class="mt-3 row px-3">
    @foreach($team->users as $member)
        <div class="card col-md-4">
            <div class="card-body">
                <h5 class="card-title">{{ $member->name }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $member->email }}</h6>
                <p class="card-text text-muted">Aanvragen: {{ $member->products()->count() }}</p>
                <a href="{{ route('users.show', $member) }}" class="card-link">Bekijken</a>
            </div>
        </div>
    @endforeach
</div>
@endsection
