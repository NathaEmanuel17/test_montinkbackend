<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Vite Scripts (caso use algum JS próprio) -->
    @vite(['resources/js/app.js'])
</head>
<body class="bg-light text-dark">

<div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-5">
    <div class="mb-4">
        <a href="/">
            {{-- Substitua por sua logo ou imagem se preferir --}}
            <img src="https://sou.montink.com/wp-content/uploads/2024/04/logo.png" alt="Logo" class="img-fluid" style="max-width: 80px;">
        </a>
    </div>

    <div class="w-100" style="max-width: 420px;">
        <div class="card shadow-sm">
            <div class="card-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

</body>
</html>
