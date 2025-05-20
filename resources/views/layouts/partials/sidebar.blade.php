@php $role = Auth::user()->role; @endphp

<style>
  /* Fondo moderno con efecto glass + partículas */
  .sb-sidenav {
    background: radial-gradient(circle at top left, #1a1f2b, #0d0d0d);
    background-size: cover;
    position: relative;
    overflow: hidden;
    border-right: 1px solid rgba(255, 255, 255, 0.05);
    box-shadow: inset 0 0 25px rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(8px);
  }

  .sb-sidenav::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background-image: radial-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px);
    background-size: 40px 40px;
    animation: moveDots 20s linear infinite;
    z-index: 0;
  }

  @keyframes moveDots {
    from { transform: translate(0, 0); }
    to { transform: translate(50px, 50px); }
  }

  /* Asegura que el contenido quede sobre las partículas */
  .sb-sidenav-menu,
  .sb-sidenav-footer {
    position: relative;
    z-index: 1;
  }

  /* Estilo a los links */
  .sb-sidenav-menu .nav-link {
    color: #ffffff;
    background-color: rgba(255, 255, 255, 0.04);
    margin-bottom: 10px;
    padding: 0.75rem 1rem;
    border-radius: 12px;
    transition: all 0.3s ease;
    font-weight: 500;
    backdrop-filter: blur(3px);
  }

  .sb-sidenav-menu .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    transform: translateX(6px);
    box-shadow: 0 4px 10px rgba(13, 202, 240, 0.4);
  }

  .sb-sidenav-menu .sb-nav-link-icon i {
    color: #79c3ff;
    transition: color 0.3s ease;
  }

  .sb-sidenav-menu .nav-link:hover .sb-nav-link-icon i {
    color: #0dcaf0;
  }

  .sb-sidenav-collapse-arrow i {
    transition: transform 0.3s ease;
  }

  .nav-link.collapsed[aria-expanded="true"] .sb-sidenav-collapse-arrow i {
    transform: rotate(180deg);
  }

  .sb-sidenav-footer {
    background: rgba(0, 0, 0, 0.25);
    color: #ffffff;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    padding: 1rem;
    font-size: 0.9rem;
    text-align: center;
    backdrop-filter: blur(5px);
  }

  .sb-sidenav-menu-heading {
    font-weight: bold;
    font-size: 0.8rem;
    text-transform: uppercase;
    color: #a0bdfd;
    margin-top: 1rem;
    margin-bottom: 0.5rem;
    letter-spacing: 1px;
  }

  .sb-sidenav-menu .nav-link {
    animation: fadeSlideIn 0.3s ease-in-out both;
  }

  @keyframes fadeSlideIn {
    from { opacity: 0; transform: translateX(-10px); }
    to { opacity: 1; transform: translateX(0); }
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
