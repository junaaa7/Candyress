// resources/js/reveal.js
// Efek fade-up: elemen ber-class "reveal" muncul halus setiap kali masuk layar,
// dan memudar lagi saat keluar layar (berlaku untuk scroll ke bawah maupun ke atas).
// Class "js-reveal" baru ditambahkan di sini, jadi kalau JavaScript gagal dimuat,
// semua konten tetap terlihat normal.

const items = document.querySelectorAll('.reveal');
const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (items.length && 'IntersectionObserver' in window && !reduceMotion) {
    document.documentElement.classList.add('js-reveal');

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                entry.target.classList.toggle('is-visible', entry.isIntersecting);
            });
        },
        { threshold: 0.15, rootMargin: '0px 0px -8% 0px' }
    );

    items.forEach((el) => observer.observe(el));
}