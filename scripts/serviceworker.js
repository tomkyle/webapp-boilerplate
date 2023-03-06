importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-sw.js');

// 'buildId' and 'buildMode' values will be changed in THIS file by Gulp's 'buildIdTask'.
var buildId=1678131047614,
    buildMode="production";

// This must come before any other workbox.* methods.
workbox.setConfig({
  debug: (buildMode === 'production')
});


// -----------------------------
// So this is Workbox.
// -----------------------------


// https://developers.google.com/web/tools/workbox/guides/configure-workbox#configure_cache_names
workbox.core.setCacheNameDetails({
  prefix: "tomkyle",
  suffix: 'v1',
  precache: 'precache',
  runtime: 'runtime',
  // googleAnalytics: 'custom-google-analytics-name'
});



// Used to limit entries in cache, remove entries after a certain period of time
// import { ExpirationPlugin } from 'workbox-expiration';

// During the service worker's install event.
workbox.precaching.precacheAndRoute(self.__WB_MANIFEST, {ignoreVary: true});

// Enable navigation preload.
workbox.navigationPreload.enable();


// ---------------------------------------
// Plugins and Strategies
// ---------------------------------------

const cacheableResponsePlugin = new workbox.cacheableResponse.CacheableResponsePlugin({
    statuses: [0, 200],
});


//
// Cache first, if result is 200 OK.
const cacheFirstStrategy = new workbox.strategies.CacheFirst({
    ignoreVary: true,
    plugins: [ cacheableResponsePlugin ],
});



//
// Network First, if result is 200 OK.
//
const networkFirstStrategy = new workbox.strategies.NetworkFirst({
    ignoreVary: true,
    plugins: [ cacheableResponsePlugin ],
});


//
// Stale While Revalidate, if result is 200 OK.
//
const staleWhileRevalidateStrategy = new workbox.strategies.StaleWhileRevalidate({
    ignoreVary: true,
    plugins: [ cacheableResponsePlugin ],
});



// ---------------------------------------
// Routing and Offline Fallback
// ---------------------------------------


workbox.recipes.offlineFallback({ pageFallback: '/offline.html'});

workbox.routing.registerRoute(
    ({ request }) => [ 'navigate', 'document'].includes(request.mode),
    networkFirstStrategy
);

workbox.routing.registerRoute(
    ({ request }) => [ 'style', 'script', 'worker'].includes(request.destination),
    staleWhileRevalidateStrategy
);

workbox.routing.registerRoute(
    ({ request }) => [ 'image', 'font'].includes(request.destination),
    cacheFirstStrategy
);




// ---------------------------------------
// Service worker semi-autoupdate
// ---------------------------------------

addEventListener('message', (event) => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});


