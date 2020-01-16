@extends('layouts.app')

@section('content')
	@if($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	@if(session('status'))
		<div class="alert alert-notification" role="alert">
			{{ session('status') }}
		</div>
	@endif

	<div class="card">
		<div class="card-header">Standaard product aanvraag</div>
		<div class="card-body">
			<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<create-std-product-view></create-std-product-view>
				<input
					name="user_id"
					type="hidden"
					value="{{ \Auth::user()->id }}">
				<input
					name="product_type"
					type="hidden"
					value="std_product"
					>
			</form>
		</div>
	</div>
@endsection
