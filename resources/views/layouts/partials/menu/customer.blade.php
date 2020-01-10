<div class="card">
    <div class="card-header">
        Menu
    </div>
    <div class="card-body">
        <ul class="nav flex-column">
			<li class="nav-item">
				<a class="nav-link" href="{{ route('products.index') }}">Alle bestellingen</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('products-standard.create') }}">Standaard product aanvragen</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ route('products.create') }}">Nieuwe aanvraag</a>
			</li>
        </ul>
    </div>
</div>
