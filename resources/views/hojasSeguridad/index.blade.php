@extends('layouts.public')

@section('content')
<link rel="stylesheet" href="{{ asset('css/hojasSeguridad.css') }}">

@php
  use Illuminate\Support\Facades\Route;
  $urlInicio = url('/');
  $urlFichas = Route::has('fichasTecnicas.index') ? route('fichasTecnicas.index') : url('/fichas-tecnicas');
@endphp

<header class="docs-hero">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
      <div class="pe-2">
        <h1 class="docs-title mb-1">Hojas de Seguridad</h1>
        <p class="docs-sub mb-0">Consulta y descarga las hojas de seguridad de nuestros productos.</p>
      </div>
      <div class="docs-actions d-flex flex-wrap gap-2">
        <a href="{{ $urlInicio }}" class="btn btn-outline-dark">
          <i class="bi bi-house-door me-1"></i> Ir al inicio
        </a>
        <a href="{{ $urlFichas }}" class="btn btn-success">
          <i class="bi bi-file-earmark-text me-1"></i> Ir a fichas técnicas
        </a>
      </div>
    </div>
  </div>
</header>

<section class="container py-4">
  {{-- Búsqueda --}}
  <div class="row justify-content-center mb-4">
    <div class="col-12 col-lg-8">
      <div class="searchbar input-group input-group-lg shadow-sm">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input id="hs-search" type="text" class="form-control" placeholder="Buscar por nombre, segmento o categoría…">
        <button id="hs-clear" class="btn btn-link text-secondary px-3 d-none" aria-label="Limpiar">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
    </div>
  </div>

  {{-- Grid --}}
  <div id="hs-grid" class="row g-4">
    @php
      use App\Models\Producto;
      use Illuminate\Support\Str;

      // Construye SIEMPRE desde productos (idéntico enfoque a FT)
      $itemsHS = Producto::query()
        ->select('id','nombre','segmento','categoria','presentacion','hojaSeguridad','FotoCatalogo','fotoProducto','fotoProducto')
        ->whereNotNull('hojaSeguridad')
        ->orderBy('nombre')
        ->get()
        ->map(function($p){
          // ---------- Normaliza PDF ----------
          $raw = (string)$p->hojaSeguridad;
          $raw = str_replace('\\','/',$raw);           // \ -> /
          $raw = preg_replace('#^public/#i','',$raw);  // quita "public/"
          $raw = ltrim($raw,'/');                      // quita "/" inicial

          // Candidatos (tu carpeta real es public/hojasSeguridad)
          $candidates = [
            $raw,                                  // si ya incluye carpeta
            "hojasSeguridad/$raw",                 // nombre solo
            "HojasSeguridad/$raw",                 // variante con mayúsculas
          ];

          // Primer candidato existente en /public
          $pdfPath = null;
          foreach ($candidates as $c) {
            if ($c && file_exists(public_path($c))) { $pdfPath = $c; break; }
          }
          if (!$pdfPath) return null; // no mostramos si no existe físicamente

          // ---------- Normaliza IMAGEN (botella completa, sin recorte) ----------
          $imgRaw = $p->FotoCatalogo ?: ($p->fotoProducto ?? null) ?: ($p->fotosProducto ?? null);
          if ($imgRaw) {
            $imgRaw = ltrim((string)$imgRaw, '/');
            $imgRaw = preg_replace('#^public/#i', '', $imgRaw);
            // Normaliza rutas antiguas a carpeta unificada
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
            'pdf'          => asset($pdfPath),
            'img'          => asset($ruta),
          ];
        })
        ->filter()
        ->values();
    @endphp

    @forelse($itemsHS as $doc)
      <div class="col-12 col-md-6 col-xl-4 doc-card-wrap"
           data-title="{{ Str::lower($doc->titulo) }}"
           data-seg="{{ Str::lower($doc->segmento ?? '') }}"
           data-cat="{{ Str::lower($doc->categoria ?? '') }}">
        <div class="doc-card h-100 doc-card--primary">
          <div class="doc-card-body">
            {{-- Lado izquierdo: info --}}
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

            {{-- Lado derecho: imagen (no recortar) --}}
            <div class="doc-media" aria-hidden="true">
              <img class="doc-img"
                   src="{{ $doc->img }}"
                   alt="Imagen de {{ $doc->titulo }}"
                   loading="lazy" decoding="async">
            </div>
          </div>

          <div class="doc-card-footer">
            <a href="{{ $doc->pdf }}" target="_blank" rel="noopener" class="btn btn-doc--primary">
              <i class="bi bi-box-arrow-up-right me-1"></i> Ver hoja de seguridad
            </a>
            <a href="{{ $doc->pdf }}" download class="btn btn-doc-outline--primary">
              <i class="bi bi-download me-1"></i> Descargar
            </a>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <p class="text-center text-muted">No hay hojas de seguridad disponibles.</p>
      </div>
    @endforelse
  </div>
</section>
@endsection

@push('scripts')
<script>
(function(){
  const q = document.getElementById('hs-search');
  const clearBtn = document.getElementById('hs-clear');
  const cards = document.querySelectorAll('#hs-grid .doc-card-wrap');

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
