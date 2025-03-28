// Định nghĩa tên cache
const CACHE_NAME = 'my-app-cache-v1';
const urlsToCache = [
    '/',
    '/assets/css/app.css',
    '/assets/img/logo.png',


];

// Cài đặt Service Worker và lưu trữ các tệp vào cache
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(urlsToCache))
    );
});

// Kích hoạt Service Worker
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.filter(name => name !== CACHE_NAME)
                    .map(name => caches.delete(name))
            );
        })
    );
});

// Xử lý yêu cầu mạng, ưu tiên dùng cache nếu offline
self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => response || fetch(event.request))
    );
});


//! xử lý tự động huỷ và cập regiester

self.addEventListener("install", (event) => {
    console.log("⚡ Service Worker installing...");
    self.skipWaiting(); // Bắt Service Worker mới hoạt động ngay lập tức
  });

  self.addEventListener("activate", (event) => {
    console.log("✅ Service Worker activated!");
    event.waitUntil(
      caches.keys().then((cacheNames) => {
        return Promise.all(
          cacheNames.map((cache) => {
            if (cache !== "my-app-cache-v1") {
              console.log("🗑 Xóa cache cũ:", cache);
              return caches.delete(cache);
            }
          })
        );
      })
    );
    self.clients.claim(); // Đảm bảo Service Worker mới được áp dụng ngay
  });
