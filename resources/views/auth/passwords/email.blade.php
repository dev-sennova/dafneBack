@extends('layouts.app')

@section('content')

<div class="container">
    <div class="reset-password-container">
        <div class="reset-password-title">{{ __('Restablecer Contraseña') }}</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                        <div class="form-group">
                            <label for="email" class="col-form-label">{{ __('Correo Electrónico') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus><br>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-group row mb-0">
                                <button type="submit" class="btn-primary">
                                    {{ __('Recuperar Contraseña') }}
                                </button>
                        </div><br>
                </form>
        </div>
    </div>
</div>


@endsection
