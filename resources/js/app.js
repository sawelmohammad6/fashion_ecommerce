import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Scroll fade-in animation
document.addEventListener('DOMContentLoaded', function () {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.scroll-fade-in').forEach(el => observer.observe(el));
});

// Smooth page load
document.addEventListener('DOMContentLoaded', function () {
    document.body.classList.add('page-loaded');
});
