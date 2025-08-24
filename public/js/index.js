// Reveal on view
(function() {
  const els = document.querySelectorAll('.reveal');
  if (!('IntersectionObserver' in window) || els.length === 0) {
    els.forEach(e => e.classList.add('in-view')); return;
  }
  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) { entry.target.classList.add('in-view'); io.unobserve(entry.target); }
    });
  }, { threshold: 0.15 });
  els.forEach(e => io.observe(e));
})();

// Métricas
(function(){
  const nums = document.querySelectorAll('.stat-num');
  if (!('IntersectionObserver' in window) || nums.length === 0) return;
  const animate = (el) => {
    const target = Number(el.dataset.count || '0');
    const dur = 1200; const start = performance.now();
    const step = (now) => {
      const p = Math.min((now - start) / dur, 1);
      el.textContent = Math.floor(p * target).toLocaleString('es-MX');
      if (p < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  };
  const io = new IntersectionObserver(entries => {
    entries.forEach(en => { if (en.isIntersecting){ animate(en.target); io.unobserve(en.target); } });
  }, { threshold: 0.5 });
  nums.forEach(n => io.observe(n));
})();

// Smooth anchor offset
(function(){
  const header = document.querySelector('header.navbar, .navbar.fixed-top, .navbar.sticky-top');
  const getOffset = () => (header ? header.offsetHeight + 12 : 84);
  document.addEventListener('click', (e) => {
    const a = e.target.closest('a[href^="#"]'); if (!a) return;
    const id = a.getAttribute('href'); if (!id || id === '#') return;
    const el = document.querySelector(id); if (!el) return;
    e.preventDefault();
    const top = el.getBoundingClientRect().top + window.pageYOffset - getOffset();
    window.scrollTo({ top, behavior: 'smooth' });
  });
})();

// Carril de destacados
(function(){
  const track = document.getElementById('railTrack');
  if (!track) return;

  let isDown = false, startX = 0, scrollLeft = 0;
  const start = (x) => { isDown = true; startX = x - track.offsetLeft; scrollLeft = track.scrollLeft; track.classList.add('dragging'); };
  const move = (x) => { if (!isDown) return; const walk = (x - track.offsetLeft - startX) * 1.1; track.scrollLeft = scrollLeft - walk; };
  const end = () => { isDown = false; track.classList.remove('dragging'); };

  track.addEventListener('mousedown', e => start(e.pageX));
  track.addEventListener('mousemove', e => move(e.pageX));
  ['mouseleave','mouseup'].forEach(ev => track.addEventListener(ev, end));
  track.addEventListener('touchstart', e => start(e.touches[0].pageX), {passive:true});
  track.addEventListener('touchmove', e => move(e.touches[0].pageX), {passive:true});
  track.addEventListener('touchend', end);

  const prev = document.querySelector('.featured-rail .prev');
  const next = document.querySelector('.featured-rail .next');
  const step = () => Math.max(280, track.clientWidth * 0.8);
  prev?.addEventListener('click', () => track.scrollBy({left: -step(), behavior: 'smooth'}));
  next?.addEventListener('click', () => track.scrollBy({left: step(), behavior: 'smooth'}));
})();

// Burbujas: limita a 5, más chicas y fuera del título/botones
(function(){
  const orbit = document.getElementById('hero-orbit');
  const track = document.getElementById('railTrack');
  if (!orbit || !track) return;

  const imgs = track.querySelectorAll('.rail-card .rail-media img');
  const count = Math.min(imgs.length, 5);

  const rand = (min, max) => Math.random() * (max - min) + min;

  for (let i = 0; i < count; i++) {
    const src = imgs[i].getAttribute('src');
    const b = document.createElement('div'); b.className = 'bubble';
    const img = document.createElement('img'); img.src = src; img.alt = '';
    b.appendChild(img);

    /* Zona segura: alejadas del bloque de texto (evitamos el 0–55% ancho izquierdo y 40–75% alto central) */
    const top = rand(8, 72);
    let left = rand(58, 92);  // Preferimos derecha
    if (i % 2 === 0) left = rand(10, 30); // Algunas pocas a la izquierda pero altas o bajas
    b.style.top = `${top}%`;
    b.style.left = `${left}%`;
    b.style.setProperty('--dur', `${rand(12, 18)}s`);
    orbit.appendChild(b);
  }
})();

// Parallax suave del fondo del hero (limitado)
(function(){
  const bg = document.querySelector('.hero .hero-bg');
  if (!bg) return;
  let ticking = false;
  const onMove = (x, y) => {
    const rx = (x / window.innerWidth - 0.5) * 2;
    const ry = (y / window.innerHeight - 0.5) * 2;
    bg.style.transform = `scale(1.05) translate(${rx * 5}px, ${ry * 4}px)`;
  };
  window.addEventListener('mousemove', (e) => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    if (!ticking){ window.requestAnimationFrame(() => { onMove(e.clientX, e.clientY); ticking = false; }); ticking = true; }
  });
})();

/* --- Onda de íconos destacados --- */
(function(){
  const strip = document.getElementById('waveStrip');
  if (!strip) return;

  const items = Array.from(strip.querySelectorAll('.wave-item'));
  if (items.length === 0) return;

  let W = 0, H = 0, phase = 0;
  const cfg = {
    amplitude: 42,       // altura de la onda (px)
    baseline: 70,        // altura base dentro del carril (px)
    speed: 0.6,          // px por frame aprox (desplazamiento horizontal)
    spacingMin: 140,     // separación mínima entre iconos (px)
    spacingMax: 220      // separación máxima (se usa para distribuir)
  };

  function measure(){
    const rect = strip.getBoundingClientRect();
    W = rect.width; H = rect.height;
  }

  function layout(){
    // Distribuye en X de forma uniforme con separación variable
    const n = items.length;
    const usable = Math.max(W - 60, 300);
    const step = Math.min(cfg.spacingMax, Math.max(cfg.spacingMin, usable / n));
    for (let i=0;i<n;i++){
      const el = items[i];
      const x = (i * step + phase) % (W + step) - step/2; // bucle continuo
      const rad = (x / W) * Math.PI * 2;                  // 0..2π
      const y = H/2 + cfg.baseline * 0.0 + Math.sin(rad) * cfg.amplitude;

      el.style.left = `${x}px`;
      el.style.top  = `${y}px`;
    }
  }

  let raf;
  function tick(){
    phase += cfg.speed;   // avanza la fila hacia la derecha
    layout();
    raf = requestAnimationFrame(tick);
  }

  function onResize(){
    measure(); layout();
  }

  // Inicializa
  measure(); layout(); tick();
  window.addEventListener('resize', () => { cancelAnimationFrame(raf); onResize(); tick(); }, {passive:true});

  // Accesibilidad: pausa al no estar visible
  document.addEventListener('visibilitychange', () => {
    if (document.hidden) cancelAnimationFrame(raf);
    else { tick(); }
  });
})();
