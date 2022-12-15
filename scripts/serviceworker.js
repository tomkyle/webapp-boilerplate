// 'buildId' value will be changed in THIS file by Gulp's 'buildIdTask'.
var buildId=1671109382182;

// Customize this with a different URL if needed.
// (Also see route defintion in configs/routes.dist.yaml)
const OFFLINE_URL = '/offline';

// Name caches here
// Used to configure Worbox cache names
const CACHE_PREFIX = "tomkyle";

// - Asset files -> webpack.config.js
// - Offline URL -> configs/routes.dist.yaml
// - Favicons    -> configs/app.dist.yaml and templates/favicons.twig
const cacheFiles = [
    { url: '/manifest.webmanifest',       revision: buildId },
    { url: '/assets/styles.css',          revision: buildId },
    { url: '/assets/errors.css',          revision: buildId },
    { url: '/assets/index.mjs',           revision: buildId },
    { url: '/',                           revision: buildId },
    { url: OFFLINE_URL,                   revision: buildId },
    { url: '/favicons/favicon.svg',       revision: null },
    { url: '/favicons/favicon-32px.png',  revision: null },
    { url: '/favicons/favicon-96px.png',  revision: null },
    { url: '/favicons/favicon-180px.png', revision: null },
    { url: '/favicons/favicon-192px.png', revision: null },
    { url: '/favicons/favicon-512px.png', revision: null },
];



// -----------------------------
// So this is Workbox.
// -----------------------------


// https://developers.google.com/web/tools/workbox/guides/configure-workbox#configure_cache_names
import * as workboxCore from 'workbox-core';
workboxCore.setCacheNameDetails({
  prefix: CACHE_PREFIX,
  suffix: 'v1',
  precache: 'precache',
  runtime: 'runtime',
  // googleAnalytics: 'custom-google-analytics-name'
});



// Used to limit entries in cache, remove entries after a certain period of time
// import { ExpirationPlugin } from 'workbox-expiration';

// During the service worker's install event.
import * as workboxPrecaching from 'workbox-precaching';
workboxPrecaching.precacheAndRoute(cacheFiles, {ignoreVary: true});

// Enable navigation preload.
// import * as navigationPreload from 'workbox-navigation-preload';
// navigationPreload.enable();





// ---------------------------------------
// Plugins
// ---------------------------------------

import * as workboxCacheableResponse from 'workbox-cacheable-response';
const cacheableResponsePlugin = new workboxCacheableResponse.CacheableResponsePlugin({
    statuses: [0, 200],
});


// ---------------------------------------
// Strategies
// ---------------------------------------


import * as workboxStrategies from 'workbox-strategies';


//
// Cache First:
//
// Cache images if result is 200 OK.
// Restrict to certain number of images
// letting them expire after certain time.
const cacheFirstStrategy = new workboxStrategies.CacheFirst({
    plugins: [
      cacheableResponsePlugin,

      // // Don't cache more than 50 items, and expire them after 30 days
      // new ExpirationPlugin({
      //   cacheName: workboxCore.cacheNames.runtime,
      //   // maxEntries: 50,
      //   maxAgeSeconds: 60 * 60 * 24 * 30, // 30 Days
      // }),
    ],
});



//
// Network First:
//
// Do cache page navigations (html) if result is 200 OK.
//
const networkFirstStrategy = new workboxStrategies.NetworkFirst({
    ignoreVary: true,
    plugins: [ cacheableResponsePlugin ],
});


//
// Stale While Revalidate:
//
// Do cache CSS, JS, and Web Worker requests if result is 200 OK.
//
const staleWhileRevalidateStrategy = new workboxStrategies.StaleWhileRevalidate({
    ignoreVary: true,
    plugins: [ cacheableResponsePlugin ],
});



// ---------------------------------------
// The routing
// ---------------------------------------

import * as workboxRouting from 'workbox-routing';

workboxRouting.registerRoute(
    ({ request }) => [ 'navigate', 'document'].includes(request.mode),
    networkFirstStrategy
);

workboxRouting.registerRoute(
    ({ request }) => [ 'style', 'script', 'worker'].includes(request.destination),
    staleWhileRevalidateStrategy
);

workboxRouting.registerRoute(
    ({ request }) => [ 'image', 'font'].includes(request.destination),
    cacheFirstStrategy
);



// ---------------------------------------
// Offline Fallback
// ---------------------------------------


import * as workboxRecipes from 'workbox-recipes';
workboxRecipes.offlineFallback({ pageFallback: OFFLINE_URL});



// ---------------------------------------
// Service worker semi-autoupdate
// ---------------------------------------

addEventListener('message', (event) => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});






