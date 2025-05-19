<!-- resources/views/partials/sidebar.blade.php -->
@php $role = Auth::user()->role; @endphp

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
  <div class="sb-sidenav-menu">
    <div class="nav">
      <div class="sb-sidenav-menu-heading">Principal</div>

      {{-- Dashboard siempre --}}
      <a class="nav-link" href="{{ route('home') }}">
        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
        Dashboard
      </a>

      {{-- Solo Admin: Gestión de usuarios --}}
      @if($role === 'administrador')
        <a class="nav-link" href="{{ route('usuarios.index') }}">
          <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
          Usuarios
        </a>
      @endif

      {{-- Productos para todos --}}
      <a class="nav-link" href="{{ route('productos.index') }}">
        <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>
        Productos
      </a>

      {{-- Ventas/Compras --}}
      @if($role === 'administrador' || $role === 'empleado')
        <a class="nav-link" href="{{ route('tickets.index') }}">
          <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
          Ventas
        </a>
      @elseif($role === 'cliente')
        <a class="nav-link" href="{{ route('tickets.index') }}">
          <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
          Hacer Compra
        </a>
      @endif

      <div class="sb-sidenav-menu-heading">Otros</div>

      {{-- Perfil (común) --}}
      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePerfil"
         aria-expanded="false" aria-controls="collapsePerfil">
        <div class="sb-nav-link-icon"><i class="fas fa-user-circle"></i></div>
        Perfil
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
      </a>
      <div class="collapse" id="collapsePerfil" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
          <a class="nav-link" href="#"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Cerrar sesión
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
          <a class="nav-link" href="#">Cambiar contraseña</a>
        </nav>
      </div>

      {{-- Solo Admin: BD y reportes --}}
      @if($role === 'administrador')
        <a class="nav-link" href="#">
          <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
          Base de datos
        </a>
        <a class="nav-link" href="#">
          <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
          Reportes
        </a>
      @endif

    </div>
  </div>
  <div class="sb-sidenav-footer">
    <div class="small">Iniciado sesión como:</div>
    {{ Auth::user()->name }}
  </div>
</nav>
