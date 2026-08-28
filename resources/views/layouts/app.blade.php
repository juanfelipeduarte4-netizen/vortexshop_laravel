<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VortexShop @yield('titulo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/copiadisenos.css') }}">
</head>
<body>
    @include('partials.menu')

    <main class="container py-4">
        @if(session('exito'))
            <div class="vs-alert-exito mb-3">{{ session('exito') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-vs-error mb-3">{{ session('error') }}</div>
        @endif

        @yield('contenido')
    </main>
</body>
</html>