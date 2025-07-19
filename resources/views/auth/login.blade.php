@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center align-items-center">
            {{-- Coluna do vídeo --}}
            <div class="col-md-6 text-center mb-4 mb-md-0">
                <video autoplay muted loop class="img-fluid rounded-circle" style="max-width: 300px;">
                    <source src="https://admin.montink.com/assets/videos/montink%20dragao.mp4" type="video/mp4">
                    Seu navegador não suporta o vídeo.
                </video>
            </div>

            {{-- Coluna do formulário --}}
            <div class="col-md-6" style="max-width: 420px;">
                {{-- Status da Sessão --}}
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Endereço de E-mail --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" name="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required autofocus autocomplete="username">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Senha --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" name="password" id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required autocomplete="current-password">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">
                            Entrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
