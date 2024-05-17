@extends('layouts.app')

@section('content')

<div class="reset-password-container mt-5">
    <div class="reset-password-title">{{ __('Reestablecer Contraseña') }}</div>
    <form method="POST" action="{{ route('password.update') }}" class="reset-password-form">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <div class="form-group">
            <label for="email" class="col-form-label">{{ __('Correo Electrónico') }}</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ $email }}" required autocomplete="email" readonly>
        </div>
        <div class="form-group">
            <label for="password" class="col-form-label">{{ __('Contraseña Nueva') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            @error('password')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password-confirm" class="col-form-label">{{ __('Confirmar Contraseña') }}</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>
        <div class="form-group mb-0">
            <button type="submit" class="btn-primary">{{ __('Restablecer Contraseña') }}</button>
        </div>
    </form>
</div>


@endsection
