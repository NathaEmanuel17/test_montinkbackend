<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Loja | Produtos</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-white text-dark d-flex flex-column min-vh-100">

<div class="container py-4">
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
    <header class="d-flex justify-content-end mb-4">
        @if (Route::has('login'))
            <nav class="d-flex gap-2">
                @auth
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-dark">Meus pedidos</a>
                @else
                    <nav class="d-flex align-items-center gap-3">
                        <a href="{{ route('login') }}" class="fw-bold text-dark text-decoration-none d-flex align-items-center" style="font-size: 1.1rem;">
                            Já tenho conta <span class="ms-1">➤</span>
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn fw-bold text-black border-0 px-4 py-2"
                               style="background-color: #00FFA3; border-radius: 999px;">
                                CRIAR CONTA
                            </a>
                        @endif
                    </nav>
                @endauth
            </nav>
        @endif
    </header>

    <section class="mb-5 text-center">
        <h1 class="fw-bold mb-3">Catálogo de Produtos</h1>

        <!-- Filtros -->
        <form method="GET" class="row g-3 justify-content-center">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="Buscar produto..." value="{{ request('name') }}">
            </div>
            <div class="col-md-2">
                <input type="number" name="min_price" step="0.01" class="form-control" placeholder="Preço mínimo" value="{{ request('min_price') }}">
            </div>
            <div class="col-md-2">
                <input type="number" name="max_price" step="0.01" class="form-control" placeholder="Preço máximo" value="{{ request('max_price') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100">Filtrar</button>
            </div>
        </form>
    </section>

    <!-- Listagem -->
    @if ($products->count())
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
            @foreach ($products as $product)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm">
                        @if ($product->images->count())
                            <img src="{{ asset('storage/' . $product->images->first()->path) }}"
                                 class="card-img-top object-fit-cover"
                                 style="height: 200px;"
                                 alt="{{ $product->name }}">
                        @else
                            <div class="card-img-top d-flex justify-content-center align-items-center bg-light text-muted" style="height: 200px;">
                                <span>Sem imagem</span>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate" title="{{ $product->name }}">{{ $product->name }}</h5>
                            <p class="card-text fw-bold text-primary mb-2">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                            <p class="card-text small text-muted flex-grow-1">
                                {{ Str::limit($product->description, 80) }}
                            </p>
                            <a href="{{ route('public.product.show', $product) }}" class="btn btn-outline-primary mt-auto w-100">Ver Produto</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $products->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center text-muted">
            <p>Nenhum produto encontrado com os filtros aplicados.</p>
        </div>
    @endif
</div>

</body>
</html>
