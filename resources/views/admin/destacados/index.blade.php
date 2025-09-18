{{-- resources/views/admin/destacados/index.blade.php --}}
@extends('layouts.auth')

@section('title','Productos destacados')

@section('content')
<div class="container-fluid py-4">

  {{-- Header --}}
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
    <h1 class="h4 mb-0">
      <i class="fas fa-star text-warning me-2"></i> Productos destacados
    </h1>
    <div class="d-flex align-items-center gap-2">
      <span class="badge rounded-pill text-bg-light">Activos: <span id="countSel">0</span></span>
      <span class="badge rounded-pill text-bg-info">Min: <span id="minSel">2</span></span>
      <span class="badge rounded-pill text-bg-info">Max: <span id="maxSel">4</span></span>
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
      <div class="input-group input-group-lg" style="max-width: 720px;">
        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
        <input id="filtro" type="text" class="form-control" placeholder="Buscar producto…">
        <button class="btn btn-success px-4" type="submit">
          <i class="bi bi-floppy2 me-1"></i>Guardar cambios
        </button>
      </div>
    </div>

    {{-- Grid de cards --}}
    <div class="row g-3" id="gridProductos">
      @foreach($productos as $i => $p)
        @php
          $fp = $p->featured;
          $isActive = $fp && $fp->is_active;
          $thumb = $p->fotoProducto; // ← SOLO fotoProducto
          $thumbSrc = $thumb ? asset('img/'.ltrim($thumb,'/')) : asset('img/FotosProducto/default.png');
        @endphp
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 prod-card-wrap" data-name="{{ Str::lower($p->nombre) }}">
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

  {{-- Toast Bootstrap (bonito) --}}
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
  .prod-card { border-radius: 16px; transition: transform .15s ease, box-shadow .15s ease, border-color .15s; }
  .prod-card:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(0,0,0,.10); }
  .prod-card.active { border: 1px solid rgba(25,135,84,.35); box-shadow: 0 6px 20px rgba(25,135,84,.12); }

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
</style>
@endpush

@push('scripts')
<script>
(function(){
  const MIN_SELECTED = 2;
  const MAX_SELECTED = 4;

  const grid    = document.getElementById('gridProductos');
  const filtro  = document.getElementById('filtro');
  const countEl = document.getElementById('countSel');

  // mostrar min/max
  document.getElementById('minSel').textContent = MIN_SELECTED;
  document.getElementById('maxSel').textContent = MAX_SELECTED;

  const cards   = () => Array.from(grid.querySelectorAll('.prod-card-wrap'));
  const isChecked = wrap => wrap.querySelector('.toggle-featured').checked;

  // Toast Bootstrap
  function showToast(msg){
    const el = document.getElementById('limitToast');
    document.getElementById('limitToastMsg').textContent = msg;
    const t = bootstrap.Toast.getOrCreateInstance(el, { delay: 2500 });
    t.show();
  }

  function setActiveUI(wrap, enabled){
    wrap.querySelector('.prod-card').classList.toggle('active', enabled);
    const i = wrap.querySelector('.toggle-featured').dataset.row;
    wrap.querySelectorAll(`input[name="items[${i}][product_id]"], input[name="items[${i}][is_active]"]`)
      .forEach(inp => { inp.disabled = !enabled; if (inp.name.endsWith('[is_active]')) inp.value = enabled ? 1 : 0; });
    const badgeSlot = wrap.querySelector('.status-badge');
    badgeSlot.innerHTML = enabled
      ? `<span class="badge rounded-pill text-bg-success"><i class="bi bi-check2 me-1"></i>Activo</span>`
      : `<span class="badge rounded-pill text-bg-secondary">Inactivo</span>`;
  }

  function updateCount(){
    const selected = cards().filter(isChecked).length;
    countEl.textContent = selected;
    return selected;
  }

  function handleToggle(e){
    const wrap = e.target.closest('.prod-card-wrap');

    // Después del cambio, el checkbox ya refleja el nuevo valor
    const selected = cards().filter(isChecked).length;

    // Permite el 4.º, bloquea el 5.º
    if (selected > MAX_SELECTED){
      e.target.checked = false;
      setActiveUI(wrap, false);
      showToast(`Máximo permitido: ${MAX_SELECTED} productos activos.`);
      updateCount();
      return;
    }

    setActiveUI(wrap, e.target.checked);
    updateCount();
  }

  // Bind toggles
  document.querySelectorAll('.toggle-featured').forEach(chk=>{
    chk.addEventListener('change', handleToggle);
  });

  // Contador inicial
  updateCount();

  // Filtro por nombre
  filtro.addEventListener('input', function(){
    const q = this.value.trim().toLowerCase();
    cards().forEach(wrap=>{
      const name = (wrap.dataset.name || '').toLowerCase();
      wrap.style.display = name.includes(q) ? '' : 'none';
    });
  });

  // Validación min/max al enviar
  document.getElementById('formDestacados').addEventListener('submit', function(e){
    const selected = cards().filter(isChecked).length;
    if (selected < MIN_SELECTED){
      e.preventDefault();
      showToast(`Debes seleccionar al menos ${MIN_SELECTED} productos activos.`);
    } else if (selected > MAX_SELECTED){
      e.preventDefault();
      showToast(`Máximo permitido: ${MAX_SELECTED} productos activos.`);
    }
  });
})();
</script>
@endpush
