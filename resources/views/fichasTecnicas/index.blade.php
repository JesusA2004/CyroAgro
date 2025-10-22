@extends('layouts.public')

@section('content')
<link rel="stylesheet" href="{{ asset('css/hojasSeguridad.css') }}">

@php
  use Illuminate\Support\Facades\Route;
  $urlInicio = url('/');
  $urlHojas  = Route::has('hojasSeguridad.index') ? route('hojasSeguridad.index') : url('/hojas-seguridad');
@endphp

<header class="docs-hero">
  <div class="container d-flex flex-column gap-3">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
      <div>
        <h1 class="docs-title mb-1">Fichas Técnicas</h1>
        <p class="docs-sub mb-0">Consulta y descarga las fichas técnicas de nuestros productos.</p>
      </div>

      <!-- Botonera -->
      <div class="docs-actions d-flex flex-wrap gap-2">
        <a href="{{ $urlInicio }}" class="btn btn-outline-dark">
          <i class="bi bi-house-door me-1"></i> Ir al inicio
        </a>
        <a href="{{ $urlHojas }}" class="btn btn-success">
          <i class="bi bi-shield-check me-1"></i> Ir a hojas de seguridad
        </a>
      </div>
    </div>
  </div>
</header>

<section class="container py-4">
  {{-- Toolbar de búsqueda --}}
  <div class="row justify-content-center mb-4">
    <div class="col-12 col-lg-8">
      <div class="searchbar input-group input-group-lg shadow-sm">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input id="ft-search" type="text" class="form-control" placeholder="Buscar por nombre, segmento o categoría…">
        <button id="ft-clear" class="btn btn-link text-secondary px-3 d-none" aria-label="Limpiar">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
    </div>
  </div>

  {{-- Grid de documentos desde Producto --}}
  <div id="ft-grid" class="row g-4">
    @php
      use App\Models\Producto;
      use Illuminate\Support\Str;

      $itemsFT = ($fichasTecnicas ?? null);

      if (!$itemsFT) {
        $itemsFT = Producto::query()
          ->select('id','nombre','segmento','categoria','presentacion','fichaTecnica','FotoCatalogo','fotoProducto','fotoProducto')
          ->whereNotNull('fichaTecnica')
          ->orderBy('nombre')
          ->get()
          ->map(function($p){
            // PDF
            $raw = trim((string)$p->fichaTecnica, '/');
            $raw = preg_replace('#^public/#i','',$raw);
            $exists = $raw && file_exists(public_path($raw));
            if (!$exists) return null;

            // IMAGEN
            $imgRaw = $p->FotoCatalogo ?: ($p->fotoProducto ?? null) ?: ($p->fotosProducto ?? null);
            if ($imgRaw) {
              $imgRaw = ltrim((string)$imgRaw, '/');
              $imgRaw = preg_replace('#^public/#i', '', $imgRaw);
              $ruta = str_contains($imgRaw, '/')
                  ? preg_replace('#^(img/)?Fotos(Productos?|Catalogo)/#i', 'img/FotosProducto/', $imgRaw)
                  : 'img/FotosProducto/' . $imgRaw;
            } else {
              $ruta = 'img/generica.png';
            }
            if (!file_exists(public_path($ruta))) {
              $ruta = 'img/generica.png';
            }

            return (object)[
              'id'           => $p->id,
              'titulo'       => $p->nombre,
              'segmento'     => $p->segmento,
              'categoria'    => $p->categoria,
              'presentacion' => $p->presentacion,
              'pdf'          => asset($raw),
              'img'          => asset($ruta),
            ];
          })
          ->filter()
          ->values();
      }
    @endphp

    @forelse($itemsFT as $doc)
      <div class="col-12 col-md-6 col-xl-4 doc-card-wrap"
           data-title="{{ Str::lower($doc->titulo) }}"
           data-seg="{{ Str::lower($doc->segmento ?? '') }}"
           data-cat="{{ Str::lower($doc->categoria ?? '') }}">
        <div class="doc-card h-100 doc-card--primary">
          <div class="doc-card-body">
            <div class="doc-info">
              <div class="doc-badges mb-2">
                @if(!empty($doc->segmento))
                  <span class="badge rounded-pill bg-soft-green">{{ $doc->segmento }}</span>
                @endif
                @if(!empty($doc->categoria))
                  <span class="badge rounded-pill bg-soft-blue">{{ $doc->categoria }}</span>
                @endif
              </div>
              <h5 class="doc-title">{{ $doc->titulo }}</h5>
              @if(!empty($doc->presentacion))
                <p class="doc-desc">Presentación: {{ $doc->presentacion }}</p>
              @endif
            </div>

            <div class="doc-media" aria-hidden="true">
              <img class="doc-img" src="{{ $doc->img }}" alt="Imagen de {{ $doc->titulo }}" loading="lazy" decoding="async">
            </div>
          </div>

          <div class="doc-card-footer">
            <a href="{{ $doc->pdf }}" target="_blank" rel="noopener" class="btn btn-doc--primary">
              <i class="bi bi-box-arrow-up-right me-1"></i> Ver ficha técnica
            </a>
            <a href="{{ $doc->pdf }}" download class="btn btn-doc-outline--primary">
              <i class="bi bi-download me-1"></i> Descargar
            </a>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <p class="text-center text-muted">No hay fichas técnicas disponibles.</p>
      </div>
    @endforelse
  </div>
</section>

@endsection

@push('scripts')
<script>
(function(){
  const q = document.getElementById('ft-search');
  const clearBtn = document.getElementById('ft-clear');
  const cards = document.querySelectorAll('#ft-grid .doc-card-wrap');

  function applyFilter(){
    const t = (q.value || '').trim().toLowerCase();
    cards.forEach(c => {
      const ok = !t
        || (c.dataset.title && c.dataset.title.includes(t))
        || (c.dataset.seg && c.dataset.seg.includes(t))
        || (c.dataset.cat && c.dataset.cat.includes(t));
      c.style.display = ok ? '' : 'none';
    });
    clearBtn.classList.toggle('d-none', !t.length);
  }
  q?.addEventListener('input', applyFilter);
  clearBtn?.addEventListener('click', ()=>{ q.value=''; applyFilter(); });
})();
</script>
@endpush

@section('footer')
  @include('includes.footer')
@endsection
