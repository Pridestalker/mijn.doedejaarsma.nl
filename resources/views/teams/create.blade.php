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
            Bedrijf aanmaken
        </div>
        <div class="card-body">
            <form action="{{ route('teams.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Naam</label>
                    <input type="text" name="name" id="name" placeholder="Voer de bedrijfsnaam in..." class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">E-mailadres</label>
                    <input type="email" name="email" id="email" placeholder="Voer het bedrijfs emailadres in..." class="form-control">
                </div>
                <button type="submit" class="btn btn-primary text-white">Invoeren</button>
            </form>
        </div>
    </div>
@endsection
