<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Bootstrap Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-white text-dark d-flex flex-column min-vh-100">

<div class="container py-4">
    <header class="d-flex justify-content-end mb-4">
        @if (Route::has('login'))
            <nav class="d-flex gap-2">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.sales.index') }}" class="btn btn-outline-dark">Vendas</a>
                    @else
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-dark">Meus Pedidos</a>
                    @endif

                @else
                    <header class="d-flex justify-content-end mb-4">
                        @if (Route::has('login'))
                            <nav class="d-flex align-items-center gap-3">
                                <a href="{{ route('public.products.index') }}" class="btn btn-outline-warning">
                                    Ver Loja
                                </a>
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn btn-outline-dark">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="fw-bold text-dark text-decoration-none d-flex align-items-center" style="font-size: 1.1rem;">
                                        Já tenho conta <span class="ms-1">➤</span>
                                    </a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn fw-bold text-black border-0 px-4 py-2"
                                           style="background-color: #00FFA3; border-radius: 999px;">
                                            CRIAR CONTA
                                        </a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                    </header>

                @endauth
            </nav>
        @endif
    </header>
    <main class="row justify-content-center align-items-center text-center flex-grow-1">
        <div class="col-md-6 mb-5">
            <img src="https://sou.montink.com/wp-content/uploads/2024/04/logo.png" alt="Logo" class="img-fluid mb-4" style="max-width: 200px;">

            <h1 class="fw-bold" style="font-size: 2.2rem; line-height: 1.4;">
                Ganhe dinheiro vendendo <br>
                produtos da <span style="color: #ff1493;">sua marca</span> <br>
                <span style="border-bottom: 5px solid #ff1493;">sem precisar investir</span> em estoque, <br>
                produção ou logística.
            </h1>

            <p class="text-muted mt-4" style="font-size: 1.1rem;">
                Somos uma plataforma de <strong>Print On Demand</strong>, onde pessoas ou empresas conseguem ter seus produtos<br>
                personalizados com suas estampas, vender e <span style="color: #ff1493;">lucrar muito</span>.
            </p>
        </div>

        <div class="col-md-6">
            <div class="elementor-element elementor-element-671e072 mas-addons-sticky-no elementor-widget elementor-widget-image animated fadeInUp"
                 data-id="671e072"
                 data-element_type="widget"
                 data-settings='{"mas_addons_sticky":"no"}'
                 data-widget_type="image.default">
                <a href="https://sou.montink.com/demonstracao?src=v3_ddb853cc-6b20-441f-a7d9-3c6947b09170_6609b0bf1062ae00080490ef_0_t-10&amp;utm_source=google_ads&amp;utm_medium=search&amp;utm_campaign=21808686952&amp;utm_content=716903343267&amp;utm_term=168178193985+g+montink++&amp;gad_source=1&amp;gad_campaignid=21808686952&amp;gbraid=0AAAAAqUREvnDkE9SWRI5pMqPCfK5N27l3&amp;gclid=Cj0KCQjwhO3DBhDkARIsANxrhTrnL0NdOOpT3mg_oYvSAD8QffgP2b9_GmnoLGiDZF6FZlGSZwjz0xYaAihREALw_wcB">
                    <img decoding="async"
                         width="420"
                         height="501"
                         src="https://sou.montink.com/wp-content/uploads/2024/04/produtos-print-on-demand-montink-2.png"
                         class="img-fluid"
                         alt="Produtos Montink"
                         srcset="https://sou.montink.com/wp-content/uploads/2024/04/produtos-print-on-demand-montink-2.png 420w,
                             https://sou.montink.com/wp-content/uploads/2024/04/produtos-print-on-demand-montink-2-251x300.png 251w"
                         sizes="(max-width: 420px) 100vw, 420px">
                </a>
            </div>
        </div>
    </main>

</div>

</body>
</html>
