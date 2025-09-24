<div class="container-fluid mt-5 px-3 px-md-5">
    {{-- Mini menú tipo panel --}}
    <div class="card shadow-sm border-0 mb-4 animate-fadein">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top px-4 py-3">
            <h5 class="mb-0 fw-bold">
                @if(!isset($producto) || !$producto->id)
                    🆕 Registro de Producto
                @else
                    ✏️ Edición de Producto
                @endif
            </h5>
            <a href="{{ route('producto.index') }}" class="btn btn-outline-light btn-sm">← Volver</a>
        </div>
    </div>

    {{-- Formulario --}}
    <div class="product-form p-4 shadow bg-white rounded-4 mx-auto mb-5 animate-fadein" style="max-width: 1280px;">
        {{-- Campos (SOLO los que existen en la tabla) --}}
        <div class="row gx-4 gy-4">
            {{-- nombre, segmento, categoria, registro --}}
            @foreach ([
                'nombre'   => 'Nombre',
                'segmento' => 'Segmento',
                'categoria'=> 'Categoría',
                'registro' => 'Registro',
            ] as $field => $label)
                <div class="col-12 col-md-6 col-lg-4">
                    <label for="{{ $field }}" class="form-label fw-semibold">{{ $label }}</label>
                    <input type="text" name="{{ $field }}" id="{{ $field }}"
                           class="form-control rounded-3 shadow-sm @error($field) is-invalid @enderror"
                           value="{{ old($field, $producto?->$field) }}">
                    @error($field)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach

            {{-- contenido (largo) --}}
            <div class="col-12">
                <label for="contenido" class="form-label fw-semibold">Contenido</label>
                <textarea name="contenido" id="contenido" rows="3"
                          class="form-control rounded-3 shadow-sm @error('contenido') is-invalid @enderror">{{ old('contenido', $producto->contenido ?? '') }}</textarea>
                @error('contenido')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- usoRecomendado (largo) --}}
            <div class="col-12">
                <label for="usoRecomendado" class="form-label fw-semibold">Uso recomendado</label>
                <textarea name="usoRecomendado" id="usoRecomendado" rows="3"
                          class="form-control rounded-3 shadow-sm @error('usoRecomendado') is-invalid @enderror">{{ old('usoRecomendado', $producto->usoRecomendado ?? '') }}</textarea>
                @error('usoRecomendado')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- dosisSugerida, intervaloAplicacion --}}
            @foreach ([
                'dosisSugerida'       => 'Dosis sugerida',
                'intervaloAplicacion' => 'Intervalo de aplicación',
            ] as $field => $label)
                <div class="col-12 col-md-6">
                    <label for="{{ $field }}" class="form-label fw-semibold">{{ $label }}</label>
                    <input type="text" name="{{ $field }}" id="{{ $field }}"
                           class="form-control rounded-3 shadow-sm @error($field) is-invalid @enderror"
                           value="{{ old($field, $producto?->$field) }}">
                    @error($field)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach

            {{-- controla (largo) --}}
            <div class="col-12">
                <label for="controla" class="form-label fw-semibold">Controla</label>
                <textarea name="controla" id="controla" rows="3"
                          class="form-control rounded-3 shadow-sm @error('controla') is-invalid @enderror">{{ old('controla', $producto->controla ?? '') }}</textarea>
                @error('controla')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- PRESENTACIÓN + PDFs --}}
            <div class="col-12 col-md-6 col-lg-4">
                <label for="presentacion" class="form-label fw-semibold">Presentación</label>
                <input type="text" name="presentacion" id="presentacion"
                       class="form-control rounded-3 shadow-sm @error('presentacion') is-invalid @enderror"
                       value="{{ old('presentacion', $producto->presentacion ?? '') }}">
                @error('presentacion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @php
                $fichaPath  = ltrim((string)($producto->fichaTecnica  ?? ''), '/');
                $hojaPath   = ltrim((string)($producto->hojaSeguridad ?? ''), '/');
                $fichaOk    = $fichaPath !== '' && file_exists(public_path($fichaPath));
                $hojaOk     = $hojaPath  !== '' && file_exists(public_path($hojaPath));
            @endphp

            {{-- FICHA TÉCNICA (PDF) --}}
            <div class="col-12 col-md-6 col-lg-4">
                <label class="form-label fw-semibold d-block">Ficha técnica (PDF)</label>

                {{-- rutas y flags ocultos --}}
                <input type="hidden" name="fichaTecnica" id="fichaTecnicaRuta" value="{{ old('fichaTecnica', $producto->fichaTecnica ?? '') }}">
                <input type="hidden" name="remove_fichaTecnica" id="removeFichaFlag" value="0">

                <input type="file" name="fichaTecnica_file" id="fichaTecnicaInput"
                       class="d-none" accept="application/pdf" data-max-bytes="{{ 20 * 1024 * 1024 }}">

                <div class="pdf-picker position-relative">
                    <button type="button"
                            class="btn w-100 py-3 border rounded-3 d-flex align-items-center justify-content-center gap-2"
                            onclick="document.getElementById('fichaTecnicaInput').click()">
                        <i class="bi bi-file-earmark-pdf-fill {{ ($fichaOk || old('fichaTecnica')) ? 'text-danger' : 'text-dark' }}" style="font-size:1.8rem;"></i>
                        <span id="fichaTecnicaLabel" class="small text-truncate" style="max-width: 75%;">
                            {{ $fichaOk ? basename($fichaPath) : (old('fichaTecnica') ? basename(old('fichaTecnica')) : 'Sin archivo (máx. 20 MB)') }}
                        </span>
                    </button>
                    {{-- X visible si ya hay archivo existente --}}
                    <button type="button" id="clearFichaBtn"
                            class="btn btn-sm btn-outline-secondary pdf-clear-btn {{ ($fichaOk || old('fichaTecnica')) ? '' : 'd-none' }}"
                            title="Quitar archivo">&times;</button>
                </div>

                @if($fichaOk)
                    <a id="fichaLink" href="{{ asset($fichaPath) }}" target="_blank" class="d-inline-block mt-2 small">Abrir archivo actual</a>
                @else
                    <a id="fichaLink" href="#" class="d-inline-block mt-2 small d-none" target="_blank">Abrir archivo actual</a>
                @endif

                <small class="text-muted d-block mt-1">Solo PDF. Límite: 20 MB</small>

                @error('fichaTecnica_file')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- HOJA DE SEGURIDAD (PDF) --}}
            <div class="col-12 col-md-6 col-lg-4">
                <label class="form-label fw-semibold d-block">Hoja de seguridad (PDF)</label>

                <input type="hidden" name="hojaSeguridad" id="hojaSeguridadRuta" value="{{ old('hojaSeguridad', $producto->hojaSeguridad ?? '') }}">
                <input type="hidden" name="remove_hojaSeguridad" id="removeHojaFlag" value="0">

                <input type="file" name="hojaSeguridad_file" id="hojaSeguridadInput"
                       class="d-none" accept="application/pdf" data-max-bytes="{{ 20 * 1024 * 1024 }}">

                <div class="pdf-picker position-relative">
                    <button type="button"
                            class="btn w-100 py-3 border rounded-3 d-flex align-items-center justify-content-center gap-2"
                            onclick="document.getElementById('hojaSeguridadInput').click()">
                        <i class="bi bi-file-earmark-pdf-fill {{ ($hojaOk || old('hojaSeguridad')) ? 'text-danger' : 'text-dark' }}" style="font-size:1.8rem;"></i>
                        <span id="hojaSeguridadLabel" class="small text-truncate" style="max-width: 75%;">
                            {{ $hojaOk ? basename($hojaPath) : (old('hojaSeguridad') ? basename(old('hojaSeguridad')) : 'Sin archivo (máx. 20 MB)') }}
                        </span>
                    </button>
                    <button type="button" id="clearHojaBtn"
                            class="btn btn-sm btn-outline-secondary pdf-clear-btn {{ ($hojaOk || old('hojaSeguridad')) ? '' : 'd-none' }}"
                            title="Quitar archivo">&times;</button>
                </div>

                @if($hojaOk)
                    <a id="hojaLink" href="{{ asset($hojaPath) }}" target="_blank" class="d-inline-block mt-2 small">Abrir archivo actual</a>
                @else
                    <a id="hojaLink" href="#" class="d-inline-block mt-2 small d-none" target="_blank">Abrir archivo actual</a>
                @endif

                <small class="text-muted d-block mt-1">Solo PDF. Límite: 20 MB</small>

                @error('hojaSeguridad_file')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Imagen (fotoProducto / FotoCatalogo) --}}
        <div class="row mt-5 justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <label for="foto" class="form-label fw-semibold w-100 text-center">Foto del producto</label>

                @php
                    $imgRaw = $producto->FotoCatalogo ?: ($producto->fotoProducto ?? null) ?: ($producto->fotosProducto ?? null) ?: ($producto->urlFoto ?? null);
                    if ($imgRaw) {
                        $imgRaw = ltrim((string)$imgRaw, '/');
                        $imgRaw = preg_replace('#^public/#i', '', $imgRaw);
                        if (!str_contains($imgRaw, '/')) { $ruta = 'img/FotosProducto/' . $imgRaw; }
                        else { $ruta = preg_replace('#^(img/)?Fotos(Productos?|Catalogo)/#i', 'img/FotosProducto/', $imgRaw); }
                    } else { $ruta = 'img/generica.png'; }
                @endphp

                <div class="preview-container rounded-4 p-3 shadow-sm animate-fadein">
                    <div class="image-preview-wrapper mx-auto mb-2 position-relative" id="imagePreview">
                        <button type="button" class="btn btn-close remove-image-btn" aria-label="Eliminar" title="Quitar imagen"></button>
                        <img id="previewImage" src="{{ asset($ruta) }}" alt="Vista previa"
                             style="width:100%; max-height:250px; object-fit:contain; object-position:center; background:#fff; border-radius:8px;"
                             onerror="this.onerror=null;this.src='{{ asset('img/generica.png') }}';">
                        <label for="foto" class="image-upload-label">Cambiar imagen</label>
                    </div>
                    <input type="file" name="foto" id="foto" class="custom-file-input" accept="image/*" data-max-bytes="{{ 5 * 1024 * 1024 }}">
                    <small class="text-muted d-block mt-1 text-center">Imagen máx. 5 MB</small>
                </div>

                @error('foto')
                    <div class="invalid-feedback d-block text-danger text-center mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Botón --}}
        <div class="row mt-4">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary px-5 py-2 shadow">Guardar</button>
                <div id="pesoTotalHint" class="small text-muted mt-2"></div>
            </div>
        </div>
    </div>
</div>

{{-- ===== Modal Bootstrap para avisos ===== --}}
<div class="modal fade" id="limitModal" tabindex="-1" aria-labelledby="limitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="limitModalLabel">Archivo demasiado pesado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p id="limitModalMsg" class="mb-0">El archivo supera el límite permitido.</p>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-limit-ok>Entendido</button>
      </div>
    </div>
  </div>
</div>

@push('styles')
<style>
  .pdf-picker { margin-top: .25rem; }
  .pdf-clear-btn {
    position: absolute;
    top: 6px;
    right: 6px;
    line-height: 1;
    padding: .15rem .45rem;
    border-radius: 50rem;
    z-index: 2;
  }
  #pesoTotalHint.text-danger { font-weight: 600; }
</style>
@endpush

@push('scripts')
<script>
/* ================== LÍMITES CONFIGURABLES ================== */
const LIMITS = {
  pdfMaxBytes: 20 * 1024 * 1024,   // 20 MB por PDF
  imgMaxBytes: 5  * 1024 * 1024,   // 5 MB imagen
  totalMaxBytes: 30 * 1024 * 1024  // 30 MB suma de archivos del form
};
/* =========================================================== */

const fichaInput = document.getElementById('fichaTecnicaInput');
const hojaInput  = document.getElementById('hojaSeguridadInput');
const fotoInput  = document.getElementById('foto');

const fichaLbl = document.getElementById('fichaTecnicaLabel');
const hojaLbl  = document.getElementById('hojaSeguridadLabel');
const totalHint = document.getElementById('pesoTotalHint');

const clearFichaBtn = document.getElementById('clearFichaBtn');
const clearHojaBtn  = document.getElementById('clearHojaBtn');

const removeFichaFlag = document.getElementById('removeFichaFlag');
const removeHojaFlag  = document.getElementById('removeHojaFlag');

const fichaLink = document.getElementById('fichaLink');
const hojaLink  = document.getElementById('hojaLink');

/* ======= Modal: show/hide robustos (con o sin Bootstrap JS) ======= */
(function(){
  const MODAL_ID = 'limitModal';
  const MODAL_BACKDROP_ID = 'limitModalBackdrop';

  function ensureBackdrop() {
    let bd = document.getElementById(MODAL_BACKDROP_ID);
    if (!bd) {
      bd = document.createElement('div');
      bd.id = MODAL_BACKDROP_ID;
      bd.className = 'modal-backdrop fade show';
      bd.style.zIndex = 1050;
      document.body.appendChild(bd);
      bd.addEventListener('click', hideLimitModal);
    }
    return bd;
  }
  function removeBackdrop() {
    const bd = document.getElementById(MODAL_BACKDROP_ID);
    if (bd) bd.remove();
  }

  window.showLimitModal = function(message, title = 'Archivo demasiado pesado') {
    const msgEl = document.getElementById('limitModalMsg');
    const titleEl = document.getElementById('limitModalLabel');
    const modalEl = document.getElementById(MODAL_ID);
    if (!modalEl) return;

    if (msgEl) msgEl.textContent = message || msgEl.textContent;
    if (titleEl) titleEl.textContent = title || titleEl.textContent;

    if (window.bootstrap && bootstrap.Modal) {
      const inst = bootstrap.Modal.getOrCreateInstance(modalEl, { backdrop: true, keyboard: true, focus: true });
      inst.show();
      return;
    }

    modalEl.classList.add('show');
    modalEl.style.display = 'block';
    modalEl.removeAttribute('aria-hidden');
    modalEl.setAttribute('aria-modal','true');
    modalEl.style.zIndex = 1055;
    document.body.classList.add('modal-open');
    document.body.style.overflow = 'hidden';
    ensureBackdrop();

    const okBtn = modalEl.querySelector('[data-limit-ok]');
    okBtn?.focus();
  };

  window.hideLimitModal = function() {
    const modalEl = document.getElementById(MODAL_ID);
    if (!modalEl) return;

    if (window.bootstrap && bootstrap.Modal) {
      const inst = bootstrap.Modal.getOrCreateInstance(modalEl);
      inst.hide();
      return;
    }

    modalEl.classList.remove('show');
    modalEl.style.display = 'none';
    modalEl.setAttribute('aria-hidden','true');
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    removeBackdrop();
  };

  document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById(MODAL_ID);
    if (!modalEl) return;

    const closeBtn = modalEl.querySelector('.btn-close');
    closeBtn?.addEventListener('click', hideLimitModal);

    const okBtn = modalEl.querySelector('[data-limit-ok]');
    okBtn?.addEventListener('click', hideLimitModal);

    document.addEventListener('keydown', function(ev) {
      if (ev.key === 'Escape') {
        const visible = modalEl.classList.contains('show') || (window.bootstrap && bootstrap.Modal?.getInstance(modalEl));
        if (visible) hideLimitModal();
      }
    });
  });
})();

/* ===== utilidades ===== */
function humanSize(bytes){
  if (bytes >= 1024*1024) return (bytes/1024/1024).toFixed(1)+' MB';
  if (bytes >= 1024) return (bytes/1024).toFixed(1)+' KB';
  return bytes + ' B';
}
function setPdfIconColor(labelSelector, hasFile){
  const icon = document.querySelector(labelSelector)?.previousElementSibling;
  if(!icon) return;
  icon.classList.remove('text-dark','text-danger');
  icon.classList.add(hasFile ? 'text-danger' : 'text-dark');
}
function validateSingleFile(inputEl, maxBytes, labelEl, clearBtn, labelSelector, linkEl){
  const f = inputEl?.files?.[0];
  if(!f) {
    if (labelEl) labelEl.textContent = 'Sin archivo';
    if (clearBtn) clearBtn.classList.toggle('d-none', true);
    if (linkEl) linkEl.classList.add('d-none');
    setPdfIconColor(labelSelector, false);
    return 0;
  }
  if(f.size > maxBytes){
    showLimitModal(`"${f.name}" pesa ${humanSize(f.size)} y supera el límite permitido (${humanSize(maxBytes)}).`);
    inputEl.value = '';
    if(labelEl) labelEl.textContent = 'Sin archivo';
    if (clearBtn) clearBtn.classList.add('d-none');
    if (linkEl) linkEl.classList.add('d-none');
    setPdfIconColor(labelSelector, false);
    inputEl.dispatchEvent(new Event('change'));
    return 0;
  }
  if(labelEl) labelEl.textContent = f.name;
  if (clearBtn) clearBtn.classList.remove('d-none');
  if (linkEl) linkEl.classList.add('d-none'); // archivo nuevo aún no tiene link
  setPdfIconColor(labelSelector, true);
  if (inputEl === fichaInput && removeFichaFlag) removeFichaFlag.value = '0';
  if (inputEl === hojaInput  && removeHojaFlag)  removeHojaFlag.value  = '0';
  return f.size;
}
function currentTotalBytes(){
  let sum = 0;
  [fichaInput, hojaInput, fotoInput].forEach(el => { if(el?.files?.[0]) sum += el.files[0].size; });
  return sum;
}
function renderTotal(){
  const sum = currentTotalBytes();
  if(totalHint){
    const maxTxt = humanSize(LIMITS.totalMaxBytes);
    totalHint.textContent = sum ? `Peso total adjunto: ${humanSize(sum)} (máx. ${maxTxt})` : '';
    totalHint.classList.toggle('text-danger', sum > LIMITS.totalMaxBytes);
  }
}

/* ===== eventos de cambio ===== */
fichaInput?.addEventListener('change', () => {
  validateSingleFile(fichaInput, LIMITS.pdfMaxBytes, fichaLbl, clearFichaBtn, '#fichaTecnicaLabel', fichaLink);
  renderTotal();
});
hojaInput?.addEventListener('change', () => {
  validateSingleFile(hojaInput, LIMITS.pdfMaxBytes, hojaLbl, clearHojaBtn, '#hojaSeguridadLabel', hojaLink);
  renderTotal();
});
fotoInput?.addEventListener('change', () => {
  const f = fotoInput?.files?.[0];
  if (f && f.size > LIMITS.imgMaxBytes){
    showLimitModal(`La imagen seleccionada pesa ${humanSize(f.size)} y supera el límite (${humanSize(LIMITS.imgMaxBytes)}).`, 'Imagen demasiado pesada');
    fotoInput.value = '';
  }
  renderTotal();
});

/* ===== X para limpiar PDFs (y marcar borrado del existente) ===== */
clearFichaBtn?.addEventListener('click', () => {
  fichaInput.value = '';
  if (fichaLbl) fichaLbl.textContent = 'Sin archivo';
  setPdfIconColor('#fichaTecnicaLabel', false);
  clearFichaBtn.classList.add('d-none');
  if (removeFichaFlag) removeFichaFlag.value = '1';
  if (fichaLink) fichaLink.classList.add('d-none');
  const ruta = document.getElementById('fichaTecnicaRuta'); if (ruta) ruta.value = '';
  renderTotal();
});
clearHojaBtn?.addEventListener('click', () => {
  hojaInput.value = '';
  if (hojaLbl) hojaLbl.textContent = 'Sin archivo';
  setPdfIconColor('#hojaSeguridadLabel', false);
  clearHojaBtn.classList.add('d-none');
  if (removeHojaFlag) removeHojaFlag.value = '1';
  if (hojaLink) hojaLink.classList.add('d-none');
  const ruta = document.getElementById('hojaSeguridadRuta'); if (ruta) ruta.value = '';
  renderTotal();
});

/* ===== bloqueo al enviar si se excede ===== */
(function(){
  const form = document.querySelector('form[action="{{ route('producto.store') }}"]')
             || document.querySelector('form[action^="{{ url('/producto') }}"]')
             || document.querySelector('form[method="POST"]');

  if(!form) return;

  form.addEventListener('submit', (e) => {
    if (fichaInput?.files?.length && fichaInput.files[0].size > LIMITS.pdfMaxBytes) {
      e.preventDefault(); showLimitModal(`La ficha técnica supera el límite de ${humanSize(LIMITS.pdfMaxBytes)}.`); return;
    }
    if (hojaInput?.files?.length && hojaInput.files[0].size > LIMITS.pdfMaxBytes) {
      e.preventDefault(); showLimitModal(`La hoja de seguridad supera el límite de ${humanSize(LIMITS.pdfMaxBytes)}.`); return;
    }
    if (fotoInput?.files?.length && fotoInput.files[0].size > LIMITS.imgMaxBytes) {
      e.preventDefault(); showLimitModal(`La imagen supera el límite de ${humanSize(LIMITS.imgMaxBytes)}.`, 'Imagen demasiado pesada'); return;
    }
    const sum = currentTotalBytes();
    if (sum > LIMITS.totalMaxBytes) {
      e.preventDefault(); showLimitModal(`El peso total de archivos (${humanSize(sum)}) supera el máximo permitido (${humanSize(LIMITS.totalMaxBytes)}). Comprime o elimina adjuntos.`, 'Límite total excedido'); return;
    }
  });
})();
</script>
@endpush
