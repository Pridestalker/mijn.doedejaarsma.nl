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
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Bedrijfsnaam</th>
                    <th scope="col">email</th>
                </tr>
                </thead>
                <tbody>
                @foreach($teams as $team)
                    <tr>
                        <th scope="row">
                            <a href="{{ route('teams.show', $team) }}">
                                {{ $team->id }}
                            </a>
                        </th>
                        <td>
                            <a href="{{ route('teams.show', $team) }}">
                                {{ $team->name }}
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-primary text-white" href="mailto:{{ $team->email }}">
                                {{ $team->email }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
