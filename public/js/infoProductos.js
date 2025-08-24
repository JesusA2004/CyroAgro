document.addEventListener('DOMContentLoaded', () => {
  const grid      = document.getElementById('p-grid');
  const cards     = Array.from(grid.querySelectorAll('.p-card-wrap'));
  const empty     = document.getElementById('p-empty');
  const state     = { segment:'', classAttr:'', classValue:'', q:'' };

  // Normalizar y "slugificar" cadenas
  const slugify = (s) => {
    return (s || '').toString().trim().toLowerCase()
      .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
      .replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g,'');
  };

  // SEGMENTOS: click para filtrar
  document.querySelectorAll('.segments-nav .seg-chip').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.segments-nav .seg-chip').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      state.segment = btn.dataset.seg || '';
      apply();
    });
  });

  // SELECTS DE CLASIFICACIÓN Y VALOR
  const classSelect = document.getElementById('class-select');
  const valueSelect = document.getElementById('value-select');

  classSelect.addEventListener('change', () => {
    const attr = classSelect.value || '';
    state.classAttr  = attr;
    state.classValue = '';
    valueSelect.innerHTML = '<option value="">Selecciona valor…</option>';
    valueSelect.disabled  = true;
    if (attr && window.availableFilters && window.availableFilters[attr]) {
      window.availableFilters[attr].forEach((v) => {
        const opt = document.createElement('option');
        opt.value = slugify(v);
        opt.textContent = v;
        valueSelect.appendChild(opt);
      });
      valueSelect.disabled = false;
    }
    apply();
  });

  valueSelect.addEventListener('change', () => {
    state.classValue = valueSelect.value || '';
    apply();
  });

  // Buscador por nombre
  const searchInput = document.getElementById('p-search');
  searchInput.addEventListener('input', () => {
    state.q = searchInput.value.trim().toLowerCase();
    apply();
  });

  // Seleccionador rápido (opcional)
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

  // Aplicar filtros a las tarjetas
  function apply() {
    let visible = 0;
    cards.forEach(card => {
      const name   = card.dataset.nombre || '';
      const seg    = card.dataset.segmento || '';
      const cat    = card.dataset.categoria || '';
      const ctrl   = card.dataset.control || ''; // CSV
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

  // Modal: abrimos y rellenamos datos
  const modalEl = document.getElementById('pModal');
  const modal   = new bootstrap.Modal(modalEl);

  grid.addEventListener('click', (e) => {
    const btn = e.target.closest('.p-view');
    if (!btn) return;
    const wrap = btn.closest('.p-card-wrap');
    const data = JSON.parse(wrap.dataset.json || '{}');

    setSrc('#d-banner', data.FotoCatalogo || data.banner || '');
    setSrc('#d-botella', data.fotoProducto || data.botella || '');
    setText('#d-titulo', data.nombre || '');
    setText('#d-cat', (data.segmento || data.categoria || '—').toString());
    setText('#d-registro', data.registro || '—');
    setText('#d-contenido', data.contenido || '—');
    setText('#d-dosis', data.dosisSugerida || '—');
    setText('#d-intervalo', data.intervaloAplicacion || '—');
    setText('#d-presentacion', data.presentacion || '—');

    fillList('#d-control', data.controla ? data.controla.split(',').map(s => s.trim()) : []);
    fillTags('#d-cultivos', data.usoRecomendado ? data.usoRecomendado.split(',').map(s => s.trim()) : []);

    setHref('#d-ficha', data.fichaTecnica || null, true);
    setHref('#d-hoja', data.hojaSeguridad || null, true);

    modal.show();
  });

  function setText(sel, v){ const el = document.querySelector(sel); if (el) el.textContent = v; }
  function setSrc(sel, v){ const el = document.querySelector(sel); if (el) el.src = v ? v : ''; }
  function setHref(sel, url, hideIfMissing=false){
    const el = document.querySelector(sel);
    if (!el) return;
    if (url){ el.href = url; el.classList.remove('d-none'); } else if (hideIfMissing){ el.classList.add('d-none'); }
  }
  function fillList(sel, arr){
    const el = document.querySelector(sel);
    if (!el) return;
    el.innerHTML = '';
    (arr || []).forEach(t => {
      const li = document.createElement('li'); li.textContent = t; el.appendChild(li);
    });
  }
  function fillTags(sel, arr){
    const el = document.querySelector(sel);
    if (!el) return;
    el.innerHTML = '';
    (arr || []).forEach(t => {
      const s = document.createElement('span');
      s.className = 'tag';
      s.textContent = t;
      el.appendChild(s);
    });
  }

  // Inicializa visibilidad
  apply();
});
