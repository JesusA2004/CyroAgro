@php $role = Auth::user()->role; @endphp

<style>
  /* Fondo degradado atractivo con RGB */
  .sb-sidenav {
    background: #5865F2;   
  }

  /* Texto base blanco */
  .sb-sidenav-menu .nav-link {
      color: #ffffff;
      transition: all 0.3s ease;
      border-radius: 6px;
      margin-bottom: 6px;
      animation: fadeSlideIn 0.4s ease-in-out;
      font-weight: 500;
  }

  /* Hover con luz y sombra destacada */
  .sb-sidenav-menu .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.1);
      color: #ffffff;
      transform: translateX(6px);
      box-shadow: 0 0 15px rgba(13, 202, 240, 0.4);
  }

  /* Íconos animados en hover */
  .sb-sidenav-menu .sb-nav-link-icon i {
      color: #ccc;
      transition: color 0.3s ease;
  }

  .sb-sidenav-menu .nav-link:hover .sb-nav-link-icon i {
      color: #0dcaf0;
  }

  /* Flecha de colapsado */
  .sb-sidenav-collapse-arrow i {
      transition: transform 0.3s ease;
  }

  .nav-link.collapsed[aria-expanded="true"] .sb-sidenav-collapse-arrow i {
      transform: rotate(180deg);
  }

  /* Footer */
  .sb-sidenav-footer {
      background: #5865F2;       
      color: #ffffff;
      padding: 1rem;
      font-size: 0.9rem;
      border-top: 1px solid #444;
  }

  /* Entrada animada */
  @keyframes fadeSlideIn {
      from { opacity: 0; transform: translateX(-10px); }
      to { opacity: 1; transform: translateX(0); }
  }

  .sb-sidenav-menu .nav-link,
  .sb-sidenav-menu .nav-link .sb-nav-link-icon,
  .sb-sidenav-menu .nav-link:hover {
      color: #ffffff !important;
  }

</style>

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
  <div class="sb-sidenav-menu">
    <div class="nav">
      <div class="sb-sidenav-menu-heading text-white">Principal</div>

      <a class="nav-link" href="{{ route('home') }}">
        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Dashboard
      </a>

      @if($role === 'administrador')
        <a class="nav-link" href="{{ route('usuarios.index') }}">
          <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div> Usuarios
        </a>
      @endif

      <a class="nav-link" href="{{ route('productos.index') }}">
        <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div> Productos
      </a>

      @if($role === 'administrador' || $role === 'empleado')
        <a class="nav-link" href="{{ route('tickets.index') }}">
          <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div> Ventas
        </a>
      @elseif($role === 'cliente')
        <a class="nav-link" href="{{ route('tickets.index') }}">
          <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div> Hacer Compra
        </a>
      @endif

      <div class="sb-sidenav-menu-heading text-white">Otros</div>

      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePerfil"
         aria-expanded="false" aria-controls="collapsePerfil">
        <div class="sb-nav-link-icon"><i class="fas fa-user-circle"></i></div> Perfil
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
      </a>
      <div class="collapse" id="collapsePerfil" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
          <a class="nav-link" href="#"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
          <a class="nav-link" href="#">Cambiar contraseña</a>
        </nav>
      </div>

      @if($role === 'administrador')
        <a class="nav-link" href="#"><div class="sb-nav-link-icon"><i class="fas fa-database"></i></div> Base de datos</a>
        <a class="nav-link" href="#"><div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div> Reportes</a>
      @endif
    </div>
  </div>
  <div class="sb-sidenav-footer">
    <div class="small">Iniciado sesión como:</div>
    {{ Auth::user()->name }}
  </div>
</nav>
