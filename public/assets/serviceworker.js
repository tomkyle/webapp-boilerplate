importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-sw.js');

// 'buildId' and 'buildMode' values will be changed in THIS file by Gulp's 'buildIdTask'.
var buildId=1690013451675,
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
workbox.precaching.precacheAndRoute([{"revision":"03aafb998008b52211175c168d011922","url":"errors.css"},{"revision":"2958cce6cbaca85f906df0b97ac7dd3b","url":"index.mjs"},{"revision":"df2970d3113a8f1f4611ffeb887c30be","url":"index.mjs.LICENSE.txt"},{"revision":"bda838ef090bf63a721b6fb08cf5e49c","url":"pwa-clearcaches.mjs"},{"revision":"5858a07da2b47fa8533eddce892ca774","url":"pwa-clearcaches.mjs.LICENSE.txt"},{"revision":"dd7ad040b679a01390672d246c64cb2e","url":"styles.css"},{"revision":"9c805e3d349e4c1a6d3be8269de0c687","url":"toggle-theme.mjs"},{"revision":"082576a39ec31bc7305046c559a7b64b","url":"toggle-theme.mjs.LICENSE.txt"},{"revision":"99aff967d0ec5419643da3ec2e77acf3","url":"workbox-window.mjs"},{"revision":"822a36a462167a73122158b8d103b2e2","url":"workbox-window.mjs.LICENSE.txt"},{"revision":"9cf14f0d6ce9b6b8eb74b5734ef69eb9","url":"../favicons/favicon-180px.png"},{"revision":"ee81cb391ff413f99051d21230461449","url":"../favicons/favicon-192px.png"},{"revision":"2574cbfe984cae19145d2ce3010dd2f0","url":"../favicons/favicon-32px.png"},{"revision":"98480fc854d1c9694542cff0eda82e67","url":"../favicons/favicon-48px.png"},{"revision":"17077a7329bb9668ba0bdad947f860de","url":"../favicons/favicon-512px.png"},{"revision":"4c2af7f96afc26ee6487b7df1fd540dc","url":"../favicons/favicon-64px.png"},{"revision":"2f9d1c7188435c9b6e783196ee600b15","url":"../favicons/favicon-96px.png"},{"revision":"dd3619e605597c98c25c34a9be1467f1","url":"../favicons/favicon.svg"},{"revision":"hallo","url":"/manifest.webmanifest"},{"revision":"hallo","url":"/favicon.ico"}], {ignoreVary: true});

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


