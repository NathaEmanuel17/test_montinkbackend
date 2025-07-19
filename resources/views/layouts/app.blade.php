<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery (opcional se usar scripts customizados com jQuery) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap Bundle JS (com Popper incluído) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Bundle JS (com Popper incluso) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Vite assets (se ainda estiver usando app.css/app.js para JS personalizados ou Bootstrap via npm) -->
    @vite(['resources/js/app.js'])
</head>
<body class="bg-light text-dark">

@include('layouts.navigation')

@isset($header)
    <header class="bg-white shadow-sm border-bottom mb-3">
        <div class="container py-4">
            {{ $header }}
        </div>
    </header>
@endisset

<main class="container py-4">
    @yield('content')
</main>


</body>
</html>
