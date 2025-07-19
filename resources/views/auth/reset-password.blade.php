@extends('layouts.app') {{-- ou layouts.guest, se aplicável --}}

@section('content')
    <div class="container mt-5" style="max-width: 500px;">
        <h2 class="mb-4">{{ __('Reset Password') }}</h2>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Token oculto -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" type="email" name="email"
                       value="{{ old('email', $request->email) }}"
                       class="form-control @error('email') is-invalid @enderror"
                       required autofocus autocomplete="username">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nova Senha -->
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       required autocomplete="new-password">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirmar Senha -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="form-control @error('password_confirmation') is-invalid @enderror"
                       required autocomplete="new-password">
                @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Botão -->
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </div>
@endsection
