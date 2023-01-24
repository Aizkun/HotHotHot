
var CACHE = 'hothothot-cache-v1';


// On install, cache some resource.
self.addEventListener('install', function(evt) {
    console.log('The service worker is being installed.');
    // Open a cache and use `addAll()` with an array of assets to add all of them
    // to the cache. Ask the service worker to keep installing until the
    // returning promise resolves.
    var appShellFiles = [
        "/",
        "/img/assets/images/favicon-16x16.png",
        "/img/assets/images/favicon-32x32.png",
        "/img/assets/images/android-chrome-192x192.png",
        "/img/assets/images/android-chrome-512x512.png",
        "/sw.js",
    ];
    evt.waitUntil(caches.open(CACHE).then(function (cache) {
        return cache.addAll(appShellFiles).then(r => refresh());
    }));
});


// On fetch, use cache but update the entry with the latest contents
// from the server.
self.addEventListener('fetch', function(evt) {
    evt.respondWith(fromCache(evt.request)
        .then(function (response) {
            if (response !== undefined) {
                return response;
            }else {
                return fetch(evt.request).then(function (response) {
                let responseClone = response.clone();

                caches.open(CACHE).then(function (cache) {
                    cache.put(evt.request, responseClone);
                });
                return response;
            }).catch(function () {
                return fetch(evt.request);
            });
        }
})
    .catch(function() {
        return fetch(evt.request);
    }));

});

// Open the cache where the assets were stored and search for the requested
// resource. Notice that in case of no matching, the promise still resolves
// but it does with `undefined` as value.
function fromCache(request) {
    return caches.open(CACHE).then(function (cache) {
        return cache.match(request);
    });
}


// Update consists in opening the cache, performing a network request and
// storing the new response data.
function update(request) {
    return caches.open(CACHE).then(function (cache) {
        return fetch(request).then(function (response) {
            return cache.put(request, response.clone()).then(function () {
                return response;
            });
        });
    });
}

// Sends a message to the clients.
function refresh(response) {
    return self.clients.matchAll().then(function (clients) {
        clients.forEach(function (client) {
            // Encode which resource has been updated. By including the
            // [ETag](https://en.wikipedia.org/wiki/HTTP_ETag) the client can
            // check if the content has changed.
            var message = {
                type: 'refresh',
                url: response.url,
                // Notice not all servers return the ETag header. If this is not
                // provided you should use other cache headers or rely on your own
                // means to check if the content has changed.
                eTag: response.headers.get('ETag')
            };
            // Tell the client about the update.
            client.postMessage(JSON.stringify(message));
        });
    });
}
function deleteCache() {
    self.addEventListener('activate', (e) => {
        e.waitUntil(
            caches.keys().then((keyList) => {
                return Promise.all(keyList.map((key) => {
                    if (cacheName.indexOf(key) === -1) {
                        return caches.delete(key);
                    }
                }));
            })
        );
    });
}