<x-app-layout>
    @php
        $cartCount = session('cart') ? collect(session('cart'))->sum('quantity') : 0;
    @endphp

    @if($cartCount > 0)
        <a href="{{ route('public.cart.index') }}" class="btn btn-outline-primary position-relative">
            Carrinho
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ $cartCount }}
        </span>
        </a>
    @endif

    <div class="container py-5">
        <div class="row g-5">
            <!-- Carrossel de Imagens -->
            <div class="col-md-6">
                @if($product->images->count())
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner rounded shadow-sm">
                            @foreach($product->images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image->path) }}" class="d-block w-100" alt="Imagem do produto">
                                </div>
                            @endforeach
                        </div>
                        @if($product->images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        @endif
                    </div>
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 300px;">
                        <span class="text-muted">Sem imagem</span>
                    </div>
                @endif
            </div>

            <!-- Informações do Produto -->
            <div class="col-md-6">
                <h2 class="mb-3">{{ $product->name }}</h2>
                <h4 class="text-primary mb-3">R$ {{ number_format($product->price, 2, ',', '.') }}</h4>
                <p class="mb-4 text-muted">{{ $product->description }}</p>

                <form method="POST" action="{{ route('public.store.cart', $product) }}">
                    @if(session('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>
                    @endif
                    @csrf

                    @if ($product->variations->count())
                        <div class="mb-3">
                            <label for="variation" class="form-label">Variação</label>
                            <select name="variation_id" id="variation" class="form-select" required>
                                <option value="">Selecione</option>
                                @foreach($product->variations as $variation)
                                    <option value="{{ $variation->id }}">
                                        {{ $variation->name }} ({{ $variation->stock->quantity ?? 0 }} disponíveis)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantidade</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required>
                        @error('quantity')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror

                    </div>

                    <button type="submit" class="btn btn-dark w-100">
                        Adicionar ao Carrinho
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @endpush
</x-app-layout>
