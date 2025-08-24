document.addEventListener('DOMContentLoaded', () => {
  const grid      = document.getElementById('p-grid');
  const cards     = Array.from(grid.querySelectorAll('.p-card-wrap'));
  const empty     = document.getElementById('p-empty');
  const state     = { segment:'', classAttr:'', classValue:'', q:'' };

  // Normalizar y slugificar cadenas para filtros
  const slugify = (s) => {
    return (s || '').toString().trim().toLowerCase()
      .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
      .replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
  };

  // Normaliza las rutas de imágenes de la BD (FotosCatalogo/FotosProducto) a la carpeta img/fotosproducto
  function normalizeImgPath(p) {
    if (!p) return null;
    // elimina slash inicial
    p = p.replace(/^\/+/, '');
    // reemplaza FotosProducto o FotosCatalogo por img/fotosproducto
    return p.replace(/^Fotos(Productos?|Catalogo)\//i, 'img/fotosproducto/');
  }

  // Obtiene el root de asset() inyectado desde Blade
  const assetRoot = window.assetRoot || '/';

  // Segmentos: click para filtrar
  document.querySelectorAll('.segments-nav .seg-chip').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.segments-nav .seg-chip').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      state.segment = btn.dataset.seg || '';
      applyFilters();
    });
  });

  // SELECTS de clasificación y valor
  const classSelect = document.getElementById('class-select');
  const valueSelect = document.getElementById('value-select');

  classSelect.addEventListener('change', () => {
    const attr = classSelect.value || '';
    state.classAttr  = attr;
    state.classValue = '';
    // Reset del select de valores
    valueSelect.innerHTML = '<option value="">Selecciona valor…</option>';
    valueSelect.disabled  = true;
    // Poblar valores disponibles
    if (attr && window.availableFilters && window.availableFilters[attr]) {
      window.availableFilters[attr].forEach((v) => {
        const opt = document.createElement('option');
        opt.value = slugify(v);
        opt.textContent = v;
        valueSelect.appendChild(opt);
      });
      valueSelect.disabled = false;
    }
    applyFilters();
  });

  valueSelect.addEventListener('change', () => {
    state.classValue = valueSelect.value || '';
    applyFilters();
  });

  // Buscador por nombre
  const searchInput = document.getElementById('p-search');
  searchInput.addEventListener('input', () => {
    state.q = searchInput.value.trim().toLowerCase();
    applyFilters();
  });

  // Seleccionador rápido: abre el modal y resalta la tarjeta
  const quickSelect = document.getElementById('p-quick');
  if (quickSelect) {
    quickSelect.addEventListener('change', (e) => {
      const id = e.target.value;
      if (!id) return;
      const card = grid.querySelector(`.p-card-wrap[data-id="${id}"]`);
      if (card) {
        card.scrollIntoView({ behavior:'smooth', block:'center' });
        const btn = card.querySelector('.p-view');
        if (btn) btn.click();
      }
      e.target.value = '';
    });
  }

  // Aplica filtros a las tarjetas
  function applyFilters() {
    let visible = 0;
    cards.forEach(card => {
      const name   = card.dataset.nombre || '';
      const seg    = card.dataset.segmento || '';
      const cat    = card.dataset.categoria || '';
      const ctrl   = card.dataset.control || ''; // CSV slugificado
      const cult   = card.dataset.cultivo || '';
      let show = true;

      // Búsqueda por nombre
      if (state.q && !name.includes(state.q)) show = false;

      // Filtro por segmento
      if (show && state.segment) {
        if (seg !== state.segment) show = false;
      }

      // Filtro por clasificación + valor
      if (show && state.classAttr && state.classValue) {
        switch (state.classAttr) {
          case 'segmento':
            if (seg !== state.classValue) show = false;
            break;
          case 'categoria':
            if (cat !== state.classValue) show = false;
            break;
          case 'control':
            if (!ctrl.split(',').includes(state.classValue)) show = false;
            break;
          case 'cultivo':
            if (!cult.split(',').includes(state.classValue)) show = false;
            break;
        }
      }

      card.classList.toggle('d-none', !show);
      if (show) visible++;
    });
    empty.classList.toggle('d-none', visible > 0);
  }

  // Inicializa visibilidad de tarjetas
  applyFilters();

  // Modal de detalle
  const modalEl = document.getElementById('pModal');
  // Si Bootstrap está disponible, inicializa modal
  const modal   = (window.bootstrap && bootstrap.Modal) ? new bootstrap.Modal(modalEl) : null;

  // Click en botón "Ver producto"
  grid.addEventListener('click', (e) => {
    const btn = e.target.closest('.p-view');
    if (!btn) return;
    const wrap = btn.closest('.p-card-wrap');
    if (!wrap) return;

    // Obtiene el JSON de datos
    const data = JSON.parse(wrap.dataset.json || '{}');

    // Imagen de portada (banner). Si no tienes un banner por producto, deja una imagen fija.
    setSrc('#d-banner', data.FotoCatalogo || data.banner || '');
    // Botella principal: FotoCatalogo > fotoProducto > placeholder
    setSrc('#d-botella', data.FotoCatalogo || data.fotoProducto || '');
    // Título y categoría
    setText('#d-titulo', data.nombre || '');
    setText('#d-cat', [data.segmento, data.categoria].filter(Boolean).join(' • ') || '—');
    // Ficha técnica
    setText('#d-registro',     data.registro || '—');
    setText('#d-contenido',    data.contenido || '—');
    setText('#d-dosis',        data.dosisSugerida || '—');
    setText('#d-intervalo',    data.intervaloAplicacion || '—');
    setText('#d-presentacion', data.presentacion || '—');
    // Listas
    fillList('#d-control', data.controla ? data.controla.split(',').map(s => s.trim()).filter(Boolean) : []);
    fillTags('#d-cultivos', data.usoRecomendado ? data.usoRecomendado.split(',').map(s => s.trim()).filter(Boolean) : []);
    // Enlaces de ficha técnica y hoja de seguridad
    setHref('#d-ficha', data.fichaTecnica || null, true);
    setHref('#d-hoja',  data.hojaSeguridad || null, true);

    // Muestra el modal (si Bootstrap está disponible)
    if (modal) modal.show();
  });

  // Helpers para actualizar el DOM
  function setText(sel, v){ const el = document.querySelector(sel); if (el) el.textContent = v; }
  function setSrc(sel, v){
    const el = document.querySelector(sel);
    if (!el) return;
    // Normaliza ruta BD a img/fotosproducto y concatena assetRoot
    const normalized = normalizeImgPath(v);
    if (normalized) {
      el.src = assetRoot + normalized;
    } else {
      el.src = assetRoot + 'img/placeholder.png';
    }
  }
  function setHref(sel, url, hideIfMissing=false){
    const el = document.querySelector(sel);
    if (!el) return;
    if (url){
      const cleaned = url.replace(/^\/+/, '');
      // Si la URL ya es absoluta (http o https), se respeta; de lo contrario, se concatena assetRoot
      if (/^https?:\/\//i.test(url)) {
        el.href = url;
      } else {
        el.href = assetRoot + cleaned;
      }
      el.classList.remove('d-none');
    } else if (hideIfMissing) {
      el.href = '#';
      el.classList.add('d-none');
    }
  }
  function fillList(sel, arr){
    const el = document.querySelector(sel);
    if (!el) return;
    el.innerHTML = '';
    (arr || []).forEach(t => {
      const li = document.createElement('li');
      li.textContent = t;
      el.appendChild(li);
    });
  }
  function fillTags(sel, arr){
    const el = document.querySelector(sel);
    if (!el) return;
    el.innerHTML = '';
    (arr || []).forEach(t => {
      const span = document.createElement('span');
      span.className = 'tag';
      span.textContent = t;
      el.appendChild(span);
    });
  }
});
