/*
 * Animaciones para la página de detalle de producto.
 *
 * Este archivo aplica un efecto parallax sobre la imagen de fondo del hero
 * y inicializa AOS para animaciones al hacer scroll. También incluye un
 * observador para elementos personalizados si se quisiera añadir animaciones
 * adicionales a otros elementos en el futuro.
 */

document.addEventListener('DOMContentLoaded', () => {
    // Configurar AOS
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            offset: 120,
            once: true,
            easing: 'ease-in-out',
        });
    }

    // Parallax en el hero del detalle del producto
    const hero = document.querySelector('.product-hero');
    function updateParallax() {
        if (!hero) return;
        const scrollY = window.pageYOffset;
        hero.style.backgroundPositionY = `${scrollY * -0.3}px`;
    }
    window.addEventListener('scroll', updateParallax, { passive: true });
    updateParallax();
});