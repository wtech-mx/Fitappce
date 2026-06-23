const STATIC_CACHE = 'fitapp-static-v2';
const PAGE_CACHE = 'fitapp-pages-v1';
const MEDIA_CACHE = 'fitapp-media-v1';
const PRECACHE = [
  '/fitapp/offline',
  '/pwa-launch.html',
  '/fitapp/css/app.css',
  '/fitapp/img/pwa-icon-192.png',
  '/fitapp/img/pwa-icon-512.png',
  '/fitapp/img/pwa-splash-mobile.png',
  '/fitapp/img/pwa-splash-desktop.png',
  '/manifest.webmanifest'
];

self.addEventListener('install', event => {
  event.waitUntil(caches.open(STATIC_CACHE).then(cache => cache.addAll(PRECACHE)));
  self.skipWaiting();
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys => Promise.all(
      keys.filter(key => ![STATIC_CACHE, PAGE_CACHE, MEDIA_CACHE].includes(key)).map(key => caches.delete(key))
    )).then(() => self.clients.claim())
  );
});

self.addEventListener('message', event => {
  if (event.data?.type === 'CLEAR_PRIVATE') {
    event.waitUntil(Promise.all([caches.delete(PAGE_CACHE), caches.delete(MEDIA_CACHE)]));
  }
});

function isPrivateClientPage(url) {
  return [
    '/fitapp/dashboard', '/fitapp/rutina', '/fitapp/rutina-dia/',
    '/fitapp/nutricion-diaria', '/fitapp/plan-alimentario', '/fitapp/progreso',
    '/fitapp/progreso-corporal', '/fitapp/logros', '/fitapp/perfil'
  ].some(path => url.pathname === path || url.pathname.startsWith(path));
}

async function networkFirstPage(request) {
  const cache = await caches.open(PAGE_CACHE);
  try {
    const response = await fetch(request);
    if (response.ok && !response.redirected) await cache.put(request, response.clone());
    return response;
  } catch (error) {
    return (await cache.match(request)) || (await caches.match('/fitapp/offline'));
  }
}

async function cacheFirst(request, cacheName) {
  const cache = await caches.open(cacheName);
  const cached = await cache.match(request);
  if (cached) return cached;
  const response = await fetch(request);
  if (response.ok || response.type === 'opaque') await cache.put(request, response.clone());
  return response;
}

self.addEventListener('fetch', event => {
  const request = event.request;
  if (request.method !== 'GET') return;

  const url = new URL(request.url);
  if (url.origin === self.location.origin) {
    if (url.pathname.startsWith('/admin') || url.pathname.startsWith('/fitapp/auth') || url.pathname === '/fitapp/sync-context') return;

    if (request.mode === 'navigate' && isPrivateClientPage(url)) {
      event.respondWith(networkFirstPage(request));
      return;
    }

    if (url.pathname.startsWith('/fitapp/media/exercises/')) {
      event.respondWith(cacheFirst(request, MEDIA_CACHE));
      return;
    }

    if (url.pathname.startsWith('/fitapp/css/') || url.pathname.startsWith('/fitapp/img/') || url.pathname === '/manifest.webmanifest' || url.pathname === '/pwa-launch.html') {
      event.respondWith(cacheFirst(request, STATIC_CACHE));
    }
    return;
  }

  if (url.hostname === 'cdn.jsdelivr.net' || url.hostname === 'fonts.googleapis.com' || url.hostname === 'fonts.gstatic.com') {
    event.respondWith(cacheFirst(request, STATIC_CACHE));
  }
});
