self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open('ninja-control-v1').then(function(cache) {
      return cache.addAll([
        '/',
        '/index.php',
        '/assets/css/tailwind.min.css',
        '/assets/js/jquery.min.js',
        '/assets/img/ninjaLogo.png'
      ]);
    })
  );
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request).then(function(response) {
      return response || fetch(event.request);
    })
  );
});
