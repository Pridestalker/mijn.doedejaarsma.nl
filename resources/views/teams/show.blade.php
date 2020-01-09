@extends('layouts.app')
@php($hours = $team->hours())
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
    <div class="card col-md-12">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kostenplaats</th>
                    </tr>
                </thead>
                @foreach($team->cost_centres as $cost_centre)
                    <tr>
                        <td>
                            {{ $cost_centre->name }}
                        </td>
                    </tr>
                @endforeach
            </table>

            <add-cost-centre team_id="{{ $team->id }}"></add-cost-centre>
        </div>
    </div>
</div>

<div class="mt-3 card">
	<div class="card-header">Toevoegen standaard product</div>
	<div class="card-body">
		<form action="{{ route('products-standard.store') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<create-std-product-for-team-view></create-std-product-for-team-view>
			<input type="hidden" name="team_id" id="team_id" value="{{$team->id}}">
		</form>
	</div>
</div>
@endsection
