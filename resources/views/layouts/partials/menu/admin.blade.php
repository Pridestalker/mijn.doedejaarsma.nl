<div class="card">
    <div class="card-header">
        Menu
    </div>
    <div class="card-body">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products.index') }}">Producten</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">Gebruikers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.index') }}">Administratie</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('teams.index') }}">Bedrijven</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('permissions.index') }}">Rechten</a>
            </li>
        </ul>
    </div>
</div>
