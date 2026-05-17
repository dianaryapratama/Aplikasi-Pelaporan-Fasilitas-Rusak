const CACHE_NAME = 'steamtek-cache-v1';

// Saat diinstal, Service Worker siap bekerja
self.addEventListener('install', (e) => {
    console.log('[Service Worker] Terinstal');
    self.skipWaiting();
});

self.addEventListener('activate', (e) => {
    console.log('[Service Worker] Aktif');
    return self.clients.claim();
});

// Mencegat request jaringan (Bypass dasar agar PWA valid)
self.addEventListener('fetch', (e) => {
    e.respondWith(fetch(e.request).catch(() => caches.match(e.request)));
});