@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        Product aanvragen
    </div>
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Naam</label>
                <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" placeholder="Naam van de opdracht...">
                <small id="nameHelp" class="form-text text-muted">Voer hier een beschrijvende naam van de opdracht in.</small>
            </div>

            <button type="submit" class="btn btn-primary text-white">Aanvraag indienen</button>
        </form>
    </div>
</div>
@endsection
