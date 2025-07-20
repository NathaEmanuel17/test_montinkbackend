<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4">Criar Novo Cupom</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Erros encontrados:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.coupons.store') }}">
            @csrf

            <div class="row">
                <!-- Código -->
                <div class="mb-3 col-md-4">
                    <label class="form-label">Código</label>
                    <input name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}">
                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Desconto (%) -->
                <div class="mb-3 col-md-4">
                    <label class="form-label">Desconto (%)</label>
                    <input name="discount" type="number" step="0.01" class="form-control @error('discount') is-invalid @enderror" value="{{ old('discount') }}">
                    @error('discount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Valor Mínimo -->
                <div class="mb-3 col-md-4">
                    <label class="form-label">Valor Mínimo (R$)</label>
                    <input name="min_value" type="number" step="0.01" class="form-control @error('min_value') is-invalid @enderror" value="{{ old('min_value') }}">
                    @error('min_value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <!-- Validade -->
                <div class="mb-3 col-md-4">
                    <label class="form-label">Validade</label>
                    <input name="expires_at" type="date" class="form-control @error('expires_at') is-invalid @enderror" value="{{ old('expires_at') }}">
                    @error('expires_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Status -->
                <div class="mb-3 col-md-4 d-flex align-items-center">
                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" role="switch" name="status" value="1" id="statusSwitch" {{ old('status') ? 'checked' : '' }}>
                        <label class="form-check-label" for="statusSwitch">Ativo</label>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>
