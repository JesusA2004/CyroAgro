<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Principal</div>
            <a class="nav-link" href="{{ route('home') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>
            <a class="nav-link" href="{{ route('usuarios.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Usuarios
            </a>
            <a class="nav-link" href="{{ route('productos.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Productos
            </a>
            <a class="nav-link" href="{{ route('tickets.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Ventas
            </a>
            <div class="sb-sidenav-menu-heading">Otros</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Perfil
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="#">Cerrar sesión</a>
                    <a class="nav-link" href="#">Cambiar contraseña</a>
                </nav>
            </div>
            <a class="nav-link" href="#">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Base de datos
            </a>
            <a class="nav-link" href="#">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Reportes
            </a>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Iniciado sesión como:</div>
        {{ Auth::user()->name }}
    </div>
</nav>
