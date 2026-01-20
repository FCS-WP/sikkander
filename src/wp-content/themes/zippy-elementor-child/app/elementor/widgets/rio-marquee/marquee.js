/**
 * =====================================
 * Rio Marquee – Production JS
 * =====================================
 * - Infinite seamless loop
 * - Dynamic speed
 * - Pause on hover (CSS)
 * - Elementor compatible
 */

(function () {
  'use strict';

  function initRioMarquee(marquee) {
    const track = marquee.querySelector('.rio-marquee-track');
    if (!track) return;

    // Duplicate items for seamless loop
    const items = Array.from(track.children);
    items.forEach(item => {
      track.appendChild(item.cloneNode(true));
    });

    // Calculate animation duration
    const speed = parseFloat(marquee.dataset.speed) || 40;

    requestAnimationFrame(() => {
      const trackWidth = track.scrollWidth / 2;
      const duration = trackWidth / speed;

      track.style.animationDuration = duration + 's';
    });
  }

  function initAll() {
    document.querySelectorAll('.rio-marquee').forEach(initRioMarquee);
  }

  /* Frontend */
  document.addEventListener('DOMContentLoaded', initAll);

  /* Elementor editor support */
  if (window.elementorFrontend) {
    window.elementorFrontend.hooks.addAction(
      'frontend/element_ready/rio-marquee.default',
      initRioMarquee
    );
  }

})();
