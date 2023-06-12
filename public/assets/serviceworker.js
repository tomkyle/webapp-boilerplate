importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-sw.js');

// 'buildId' and 'buildMode' values will be changed in THIS file by Gulp's 'buildIdTask'.
var buildId=1686550453802,
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
workbox.precaching.precacheAndRoute([{"revision":"687c8582a87d75e4fdb8344d8a8f509c","url":"errors.css"},{"revision":"68563b73b03278c8a3d585b2cd05f576","url":"index.mjs"},{"revision":"bda838ef090bf63a721b6fb08cf5e49c","url":"pwa-clearcaches.mjs"},{"revision":"4423cce85e9987030dd7a195a677366c","url":"styles.css"},{"revision":"9c805e3d349e4c1a6d3be8269de0c687","url":"toggle-theme.mjs"},{"revision":"99aff967d0ec5419643da3ec2e77acf3","url":"workbox-window.mjs"},{"revision":"9cf14f0d6ce9b6b8eb74b5734ef69eb9","url":"../favicons/favicon-180px.png"},{"revision":"ee81cb391ff413f99051d21230461449","url":"../favicons/favicon-192px.png"},{"revision":"2574cbfe984cae19145d2ce3010dd2f0","url":"../favicons/favicon-32px.png"},{"revision":"98480fc854d1c9694542cff0eda82e67","url":"../favicons/favicon-48px.png"},{"revision":"17077a7329bb9668ba0bdad947f860de","url":"../favicons/favicon-512px.png"},{"revision":"4c2af7f96afc26ee6487b7df1fd540dc","url":"../favicons/favicon-64px.png"},{"revision":"2f9d1c7188435c9b6e783196ee600b15","url":"../favicons/favicon-96px.png"},{"revision":"dd3619e605597c98c25c34a9be1467f1","url":"../favicons/favicon.svg"},{"revision":"hallo","url":"/manifest.webmanifest"},{"revision":"hallo","url":"/favicon.ico"}], {ignoreVary: true});

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


