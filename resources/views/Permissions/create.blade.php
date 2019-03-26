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
            Permission aanmaken
        </div>
        <div class="card-body">
            <form action="{{ route('permissions.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Naam</label>
                    <input type="text" name="name" id="name" placeholder="Voer de naam in..." class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Titel</label>
                    <input type="text" name="title" id="title" placeholder="Voer de titel in..." class="form-control">
                </div>
                <button type="submit" class="btn btn-primary text-white">Invoeren</button>
            </form>
        </div>
    </div>
@endsection
