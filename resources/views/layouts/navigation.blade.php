<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="https://sou.montink.com/wp-content/uploads/2024/04/logo.png" alt="Logo" height="40">
        </a>
        <a href="{{ route('public.products.index') }}" class="btn btn-outline-warning">
            Ver Loja
        </a>

        <!-- Botão Hamburguer (responsivo) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        @php
            $cartCount = session('cart') ? collect(session('cart'))->sum('quantity') : 0;
        @endphp
        &nbsp;&nbsp;
        @if($cartCount > 0)
            <a href="{{ route('public.cart.index') }}" class="btn btn-outline-primary position-relative">
                Carrinho
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $cartCount }}
                        </span>
            </a>
        @endif

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <!-- Links à esquerda -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                @auth
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.sales.index') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                Vendas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                                Usuários
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                Produtos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ request()->routeIs('coupons.*') ? 'active' : '' }}">
                                Cupons
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- Dropdown de usuário à direita -->
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Sair</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Entrar</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrar</a>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>
</nav>
