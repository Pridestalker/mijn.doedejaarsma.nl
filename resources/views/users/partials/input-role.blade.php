<div class="form-group row">
    <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Rol') }}</label>

    <div class="col-md-6">
        <select id="role" type="text" class="custom-select{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" value="{{ old('role') }}" required>
            @foreach(DB::table('roles')->select('*')->where('name', '!=', 'banned')->get() as $role)
                <option value="{{ $role->name }}" {{ in_array($role->name, $user->getRoles()->toArray(), true)? 'selected': '' }}>{{ $role->title }}</option>
            @endforeach
        </select>

        @if ($errors->has('role'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('role') }}</strong>
            </span>
        @endif
    </div>
</div>
