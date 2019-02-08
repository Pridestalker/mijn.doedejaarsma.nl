@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center">
        Gebruikers
        @can('create', '\App\User')
            <a class="btn ml-auto btn-outline-primary" href="{{ route('register') }}" style="-webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%;">+</a>
        @endcan
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Naam</th>
                <th scope="col">Bedrijf</th>
            </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <th scope="row">
                            <a href="{{ route('users.show', $user) }}">
                                {{ $user->id }}
                            </a>
                        </th>
                        <td>
                            <a href="{{ route('users.show', $user) }}">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td>
                            @if($user->bedrijf()->exists())
                                <a href="{{ route('teams.show', $user->bedrijf()->first()) }}">
                                    {{ $user->bedrijf()->first()->name }}
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
