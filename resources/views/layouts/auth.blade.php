<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Panel de administración de CYRAgro" />
    <meta name="author" content="CYR" />
    
    <title>@yield('title', 'CYRAgro')</title>

    <!-- DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />

    <!-- Estilos personalizados -->
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet" />

    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Estilos adicionales por stack -->
    @stack('styles')

    <!-- Vite: Bootstrap incluido desde app.js -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="sb-nav-fixed">
    <!-- Top Navigation -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        @include('layouts.partials.navbar')
    </nav>

    <div id="layoutSidenav">
        <!-- Sidebar -->
        <div id="layoutSidenav_nav">
            @include('layouts.partials.sidebar')
        </div>

        <!-- Main content -->
        <div id="layoutSidenav_content">
            @yield('content')
        </div>
    </div>

    <!-- Scripts adicionales -->
    <script src="{{ asset('js/auth.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
    <!-- Bootstrap 5 JS (necesario para dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-HoAqUO4jcT5KoU2D6TwYbKQmbZ1Vr3lULhIUCWjAKrTktlhv9v+PbV7VAgAQKk9S" crossorigin="anonymous"></script>

    @stack('scripts')
</body>
</html>
