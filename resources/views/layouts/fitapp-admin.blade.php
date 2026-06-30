<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin | FitApp')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fitapp/css/app.css') }}?v={{ filemtime(public_path('fitapp/css/app.css')) }}">

    @stack('styles')
</head>
<body class="admin-shell">
    <input type="checkbox" id="adminMenuToggle" class="admin-menu-toggle" aria-hidden="true">

    <div class="admin-layout">
        <label for="adminMenuToggle" class="admin-menu-backdrop" aria-label="Cerrar menu"></label>

        @include('fitapp.admin.partials.sidebar')

        <main class="admin-main">
            <label for="adminMenuToggle" class="admin-menu-fab" aria-label="Abrir menu">
                <i class="bi bi-list"></i>
            </label>

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
