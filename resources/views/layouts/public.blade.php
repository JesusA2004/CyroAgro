<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="@yield('description', '')" />
    <meta name="author" content="@yield('author', '')" />
    <title>@yield('title', config('app.name', 'CYRAgro'))</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.png') }}" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          rel="stylesheet" crossorigin="anonymous">

    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" />

    <!-- AOS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Animate -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Custom CSS -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

    <!-- Vite -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <meta name="index-url" content="{{ route('index') }}">

    <style>

        #mainNav {
            transition: background-color 0.3s ease;
            border-bottom: none !important; /* Evita línea negra */
        }

        /* Logo ligeramente más grande */
        .navbar-logo {
            height: 60px;
            max-height: 70px;
        }

        /* Estilo general para dropdown */
        .dropdown-menu {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .dropdown-item {
            padding: 0.75rem 1.25rem;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .dropdown-item i {
            margin-right: 8px;
        }

        .dropdown-item:hover {
            background-color: #198754;
            color: #fff;
        }

        .dropdown-item:hover i {
            color: #fff;
        }
        
    </style>

    @stack('styles')
</head>
<body id="page-top">
    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid px-3">
            <a class="navbar-brand ps-3" href="{{ route('index') }}#page-top">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="navbar-logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarResponsive" aria-controls="navbarResponsive"
                    aria-expanded="false" aria-label="Alternar navegación">
                Menu <i class="fas fa-bars ms-1"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="{{ route('index') }}#page-top">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="{{ route('nosotros') }}">
                            <i class="fas fa-users"></i> Nosotros
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="{{ route('productos.index') }}">
                            <i class="fas fa-box-open"></i>  Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page-scroll" href="{{ route('contacto') }}">
                            <i class="fas fa-envelope"></i> Contacto
                        </a>
                    </li>

                    @guest
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i> Cuenta
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i> Iniciar sesión</a></li>
                                <li><a class="dropdown-item" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i> Registrarse</a></li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button class="nav-link btn btn-link" type="submit">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                                </button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    @yield('content')

    <!-- Botón flotante para subir -->
    <button id="scrollTopBtn" class="btn btn-success position-fixed bottom-0 end-0 m-4 rounded-circle shadow d-none d-flex align-items-center justify-content-center"
            style="z-index: 1050; width: 60px; height: 60px;">
        <i class="fas fa-arrow-up fa-lg"></i>
    </button>

    <!-- Botón de WhatsApp con Bootstrap -->
    <div class="position-fixed bottom-0 start-0 m-4" style="z-index: 1050;">
        <a href="https://wa.me/5217772381213" target="_blank"
            class="btn btn-success rounded-circle shadow d-flex align-items-center justify-content-center"
            style="width: 60px; height: 60px;">
            <i class="fab fa-whatsapp fa-2x text-white"></i>
        </a>
    </div>

    <!-- Footer -->
    @yield('footer')

    <!-- Scripts -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <script>AOS.init();</script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const scrollTopBtn = document.getElementById('scrollTopBtn');

            // Mostrar u ocultar botón
            window.addEventListener('scroll', function () {
            if (window.scrollY > 300) {
                scrollTopBtn.classList.remove('d-none');
            } else {
                scrollTopBtn.classList.add('d-none');
            }
            });

            // Scroll suave al top
            scrollTopBtn.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            });
        });
    </script>

    @stack('scripts')

</body>
</html>
