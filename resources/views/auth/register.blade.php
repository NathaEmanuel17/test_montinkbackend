<x-app-layout>

<div class="container mt-5" style="max-width: 500px;">
        <h2 class="mb-4">Criar conta</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nome --}}
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       class="form-control @error('name') is-invalid @enderror"
                       required autofocus autocomplete="name">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- E-mail --}}
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       required autocomplete="username">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Senha --}}
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input id="password" type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       required autocomplete="new-password">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirmar Senha --}}
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirmar senha</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="form-control @error('password_confirmation') is-invalid @enderror"
                       required autocomplete="new-password">
                @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Link para login + Botão --}}
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('login') }}" class="text-decoration-none small">
                    Já tem uma conta?
                </a>

                <button type="submit" class="btn btn-success">
                    Registrar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

