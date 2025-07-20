<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4">Detalhes do Produto</h2>

        {{-- Nome --}}
        <div class="mb-3">
            <strong>Nome:</strong>
            <p>{{ $product->name }}</p>
        </div>

        {{-- Descrição --}}
        <div class="mb-3">
            <strong>Descrição:</strong>
            <p>{{ $product->description ?? '-' }}</p>
        </div>

        {{-- Preço --}}
        <div class="mb-3">
            <strong>Preço:</strong>
            <p>R$ {{ number_format($product->price, 2, ',', '.') }}</p>
        </div>

        {{-- Imagens --}}
        @if ($product->images->count())
            <div class="mb-4">
                <strong>Imagens:</strong>
                <div class="d-flex flex-wrap gap-3 mt-2">
                    @foreach ($product->images as $image)
                        <img src="{{ asset('storage/' . $image->path) }}" alt="Imagem" width="100" height="100" class="rounded border">
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Variações --}}
        <div class="mb-4">
            <strong>Variações:</strong>
            @if($product->variations->count())
                <div class="table-responsive mt-2">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Estoque</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($product->variations as $variation)
                            <tr>
                                <td>{{ $variation->name }}</td>
                                <td>{{ $variation->stock->quantity ?? 0 }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mt-2">Nenhuma variação cadastrada.</p>
            @endif
        </div>

        {{-- Ações --}}
        <div class="d-flex gap-2">
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
</x-app-layout>
