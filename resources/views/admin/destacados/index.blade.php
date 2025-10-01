{{-- resources/views/admin/destacados/index.blade.php --}}
@extends('layouts.auth')

@section('title','Productos destacados')

@section('content')
<div class="container-fluid py-4">

  {{-- Header --}}
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
    <div>
      <h1 class="h4 mb-1">
        <i class="fas fa-star text-warning me-2"></i> Productos destacados
      </h1>
      <p class="text-muted mb-0 small">Selecciona <strong>exactamente 3</strong> productos para mostrarlos como destacados en el sitio público.</p>
    </div>

    <div class="d-flex align-items-center gap-2">
      <span class="badge rounded-pill bg-light text-dark">
        Activos: <span id="countSel" class="fw-bold ms-1">0</span><span class="ms-1">/ 3</span>
      </span>
    </div>
  </div>

  {{-- Alerts --}}
  @if(session('ok'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check2-circle me-2"></i>{{ session('ok') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.destacados.store') }}" id="formDestacados">
    @csrf

    {{-- Filtro + Guardar (alineados) --}}
    <div class="mb-3">
      <div class="input-group input-group-lg" style="max-width: 820px;">
        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
        <input id="filtro" type="text" class="form-control" placeholder="Buscar producto…">
        <button id="btnGuardar" class="btn btn-success px-4" type="submit" disabled
                title="Debes tener exactamente 3 activos para guardar">
          <i class="bi bi-floppy2 me-1"></i>Guardar cambios
        </button>
      </div>
    </div>

    {{-- Grid de cards --}}
    <div class="row g-3" id="gridProductos">
      @foreach($productos as $i => $p)
        @php
          // Compatibilidad: $p->featured (relación/atributo) con is_active
          $fp = $p->featured;
          $isActive = $fp && $fp->is_active;

          // Miniatura: intenta FotoCatalogo y luego fotoProducto; fallback default
          $thumb = $p->fotoProducto ?: $p->fotoProducto;
          $thumbSrc = $thumb
            ? asset('img/'.ltrim($thumb,'/'))
            : asset('img/FotosProducto/default.png');
        @endphp
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 prod-card-wrap"
             data-name="{{ Str::lower($p->nombre) }}">
          <div class="card prod-card h-100 shadow-sm {{ $isActive ? 'active' : '' }}">
            <div class="card-body d-flex align-items-center gap-3">
              <div class="prod-thumb flex-shrink-0">
                <img src="{{ $thumbSrc }}" alt="" class="rounded">
              </div>
              <div class="flex-grow-1">
                <div class="fw-semibold prod-name">{{ $p->nombre }}</div>
                <div class="small text-muted">ID: {{ $p->id }}</div>
              </div>
              <div class="form-check form-switch ms-auto">
                <input class="form-check-input toggle-featured"
                       type="checkbox"
                       role="switch"
                       data-row="{{ $i }}"
                       {{ $isActive ? 'checked' : '' }}>
              </div>
            </div>

            <div class="card-footer bg-white d-flex align-items-center justify-content-between">
              <span class="status-badge">
                @if($isActive)
                  <span class="badge rounded-pill text-bg-success"><i class="bi bi-check2 me-1"></i>Activo</span>
                @else
                  <span class="badge rounded-pill text-bg-secondary">Inactivo</span>
                @endif
              </span>

              {{-- inputs ocultos: solo se envían si está activo --}}
              <input type="hidden" name="items[{{ $i }}][product_id]" value="{{ $p->id }}" {{ $isActive ? '' : 'disabled' }}>
              <input type="hidden" name="items[{{ $i }}][is_active]" value="{{ $isActive ? 1 : 0 }}" {{ $isActive ? '' : 'disabled' }}>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </form>

  {{-- Toast Bootstrap --}}
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="limitToast" class="toast align-items-center text-bg-dark border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" id="limitToastMsg">Mensaje</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>

</div>
@endsection

@push('styles')
<style>
  .prod-card {
    border-radius: 16px;
    transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
    border: 1px solid rgba(0,0,0,.06);
  }
  .prod-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 28px rgba(0,0,0,.10);
  }
  .prod-card.active {
    border: 1px solid rgba(25,135,84,.35);
    box-shadow: 0 6px 20px rgba(25,135,84,.12);
  }

  /* Miniatura: imagen completa, sin corte */
  .prod-thumb img{
    width: 110px;
    height: 110px;
    object-fit: contain;
    background: #fff;
    border: 1px solid #eef2f7;
    border-radius: 12px !important;
    padding: 8px;
  }
  @media (min-width: 1400px){
    .prod-thumb img{ width: 124px; height: 124px; }
  }

  .prod-name { font-size: 1.06rem; line-height: 1.25; }

  /* Estado del contador */
  #countSel.ok { color: #198754; }
  #countSel.warn { color: #dc3545; }
</style>
@endpush

@push('scripts')
<script>
(function(){
  const EXACT_SELECTED = 3;

  const grid      = document.getElementById('gridProductos');
  const filtro    = document.getElementById('filtro');
  const countEl   = document.getElementById('countSel');
  const btnGuardar= document.getElementById('btnGuardar');

  const cards   = () => Array.from(grid.querySelectorAll('.prod-card-wrap'));
  const isChecked = wrap => wrap.querySelector('.toggle-featured').checked;

  // Toast Bootstrap
  function showToast(msg){
    const el = document.getElementById('limitToast');
    document.getElementById('limitToastMsg').textContent = msg;
    const t = bootstrap.Toast.getOrCreateInstance(el, { delay: 2200 });
    t.show();
  }

  function setActiveUI(wrap, enabled){
    wrap.querySelector('.prod-card').classList.toggle('active', enabled);
    const i = wrap.querySelector('.toggle-featured').dataset.row;
    wrap.querySelectorAll(`input[name="items[${i}][product_id]"], input[name="items[${i}][is_active]"]`)
      .forEach(inp => { 
        inp.disabled = !enabled;
        if (inp.name.endsWith('[is_active]')) inp.value = enabled ? 1 : 0;
      });
    const badgeSlot = wrap.querySelector('.status-badge');
    badgeSlot.innerHTML = enabled
      ? `<span class="badge rounded-pill text-bg-success"><i class="bi bi-check2 me-1"></i>Activo</span>`
      : `<span class="badge rounded-pill text-bg-secondary">Inactivo</span>`;
  }

  function updateCountUI(){
    const selected = cards().filter(isChecked).length;
    countEl.textContent = selected;
    if (selected === EXACT_SELECTED){
      countEl.classList.remove('warn'); countEl.classList.add('ok');
      btnGuardar.disabled = false;
      btnGuardar.removeAttribute('title');
    } else {
      countEl.classList.remove('ok'); countEl.classList.add('warn');
      btnGuardar.disabled = true;
      btnGuardar.setAttribute('title','Debes tener exactamente 3 activos para guardar');
    }
    return selected;
  }

  function handleToggle(e){
    const wrap = e.target.closest('.prod-card-wrap');
    const turningOn = e.target.checked;

    // Si se intenta activar y ya hay 3 activos, bloqueamos este ON
    if (turningOn){
      const selectedBefore = cards().filter(isChecked).length - 0; // ya está en true
      // Nota: cuando se dispara change, el checkbox ya cambió a true,
      // por lo que contamos y si excede 3, revertimos.
      if (selectedBefore > EXACT_SELECTED){
        e.target.checked = false;
        setActiveUI(wrap, false);
        showToast(`Solo puedes tener ${EXACT_SELECTED} productos activos.`);
        updateCountUI();
        return;
      }
    }

    // Aplica UI (ON/OFF) y refresca contador
    setActiveUI(wrap, e.target.checked);
    const selected = updateCountUI();

    // Mensajes de ayuda si no son 3 (sin bloquear el flujo)
    if (selected < EXACT_SELECTED){
      const faltan = EXACT_SELECTED - selected;
      showToast(`Selecciona ${faltan} producto${faltan===1?'':'s'} más para llegar a ${EXACT_SELECTED}.`);
    }
  }

  // Bind toggles
  document.querySelectorAll('.toggle-featured').forEach(chk=>{
    chk.addEventListener('change', handleToggle);
  });

  // Contador inicial
  updateCountUI();

  // Filtro por nombre
  filtro.addEventListener('input', function(){
    const q = this.value.trim().toLowerCase();
    cards().forEach(wrap=>{
      const name = (wrap.dataset.name || '').toLowerCase();
      wrap.style.display = name.includes(q) ? '' : 'none';
    });
  });

  // Validación EXACTA al enviar
  document.getElementById('formDestacados').addEventListener('submit', function(e){
    const selected = cards().filter(isChecked).length;
    if (selected !== EXACT_SELECTED){
      e.preventDefault();
      showToast(`Debes tener exactamente ${EXACT_SELECTED} activos (ahora tienes ${selected}).`);
    }
  });
})();
</script>
@endpush
