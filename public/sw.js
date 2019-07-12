const staticCache = 'staticCache';
const dynamicCache ='dynamicCache';
const assets = [
    '/home'
];

self.addEventListener('install',evt => {
    evt.waitUntil(
        caches.open(staticCache).then(cache => {
        cache.addAll(assets);
        })
    );
});

self.addEventListener('activate',evt => {
    evt.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(keys
                .filter(key => key !== staticCache && key !== dynamicCache)
                .map(key => caches.delete(key))
            )
        })
    );
});

//sem manter cache por ora
//self.addEventListener('fetch',evt => {
    // evt.respondWith(
    //     caches.match(evt.request).then(cacheRes  => {
    //         return cacheRes || fetch(evt.request).then(fetchRes => {
    //             return caches.open(dynamicCache).then(cache => {
    //                 if(evt.request.url.indexOf('/login') == -1 && evt.request.url.indexOf('/logout') == -1 ){
    //                     cache.put(evt.request.url,fetchRes.clone());
    //                     //console.log('url',evt.request.url);
    //                 }
    //                 return fetchRes;
    //             })
    //         }).catch( ()=> { 
    //             return caches.match('/pages/fallback.html');
    //         })
    //     })
    // )
//});