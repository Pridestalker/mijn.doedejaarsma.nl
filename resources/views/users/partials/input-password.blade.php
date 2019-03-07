<div class="card mt-4">
    <div class="card-header">
        Wachtwoord aanpassen
    </div>
    <div class="card-body">
        <form action="{{ route('user.edit.password', $user) }}" method="POST">
            @method('patch')
            @csrf
            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Nieuw wachtwoord') }}</label>

                <div class="col-md-6">
                    <input id="password" type="text" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required autofocus>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Bevestig wachtwoord') }}</label>

                <div class="col-md-6">
                    <input id="password_confirmation" type="text" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required>

                    @if ($errors->has('password_confirmation'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                @include('layouts.partials.forms.button', ['type' => 'submit', 'text' => 'Aanpassen'])
            </div>
        </form>
    </div>
</div>
