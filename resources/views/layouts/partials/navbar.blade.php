<style>
    /* Estilo base con degradado oscuro */
    .navbar-dark {
        background: #5865F2;
    }

    /* Logo */
    .navbar-logo {
        height: 40px;
        margin-right: 10px;
        transition: transform 0.3s ease;
    }
    .navbar-logo:hover {
        transform: scale(1.1);
    }

    /* Marca */
    .navbar-brand {
        color: #ffffff;
        font-weight: bold;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        transition: transform 0.3s ease, color 0.3s ease;
    }
    .navbar-brand:hover {
        color: #0dcaf0;
        transform: scale(1.05);
    }

    /* --- 🔧 FIX para el ícono de sidebar que no brillaba --- */
    #sidebarToggle i {
        color: #ffffff;
        transition: all 0.3s ease;
    }
    #sidebarToggle:hover i {
        color: #0dcaf0;
        transform: scale(1.25);
        text-shadow: 0 0 8px rgba(13, 202, 240, 0.7); /* Efecto de brillo */
    }

    /* Íconos del usuario */
    .navbar-nav .nav-link i {
        color: #ffffff;
        transition: all 0.3s ease;
    }
    .navbar-nav .nav-link:hover i {
        color: #0dcaf0;
        transform: scale(1.2);
        text-shadow: 0 0 8px rgba(13, 202, 240, 0.7);
    }

    /* Dropdown animado */
    .dropdown-menu {
        animation: dropdownFade 0.3s ease forwards;
        border-radius: 8px;
        background-color: #1e1e2f;
        color: #fff;
        border: none;
    }
    @keyframes dropdownFade {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .dropdown-item {
        color: #ddd;
        transition: all 0.2s ease;
    }
    .dropdown-item:hover {
        background-color: #0dcaf0;
        color: #ffffff;
        transform: translateX(4px);
    }
</style>

<div class="container-fluid d-flex align-items-center">
    <!-- Logo (puedes reemplazar src con asset('ruta') o una imagen en public/img/logo.png) -->
    <img src="{{ asset('img/logo.png') }}" alt="Logo CYRAgro" class="navbar-logo">

    <!-- Título del sistema -->
    <a class="navbar-brand ps-2" href="{{ route('home') }}">
        {{ config('app.name', 'CYRAgro') }}
    </a>

    <!-- Botón de sidebar -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 ms-3 me-4" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Espaciador y Dropdown -->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
               data-bs-toggle="dropdown" aria-expanded="false">
               <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">Perfil</a></li>
                <li><a class="dropdown-item" href="#">Cambiar contraseña</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </li>
            </ul>
        </li>
    </ul>
</div>
