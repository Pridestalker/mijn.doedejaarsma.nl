<div class="card mt-4">
    <div class="card-header">
        {{ $user->name }} - {{ __('Permissions') }}
    </div>

    <div class="card-body">
        <div class="alert alert-danger" role="alert">
            Admins only
        </div>
        @php($current = $user->getAbilities()->pluck('name'))

        <form action="{{ route('admin.user.patch.permissions', $user) }}" method="post">
            @csrf
            @foreach(\Silber\Bouncer\Database\Ability::all() as $ability)
                @if( in_array($ability->name, $current->toArray(), true))
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="{{ $ability->id }}" name="{{ $ability->id }}" checked>
                        <label class="custom-control-label" for="{{ $ability->id }}">{{ $ability->title }}</label>
                    </div>
                    @continue
                @endif
                @if($ability->name === '*')
                    @continue
                @endif
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="{{ $ability->id }}" name="{{ $ability->id }}">
                        <label class="custom-control-label" for="{{ $ability->id }}">{{ $ability->title }}</label>
                    </div>
            @endforeach
            <button type="submit" class="btn btn-primary text-white my-2">
                Aanpassen
            </button>
        </form>
    </div>
</div>
