// index.js





import(/* webpackChunkName: 'pwa-clearcaches' */ "pwa-clearcaches")
.then(module => module.default)
.then(PwaClearCaches => {
    new PwaClearCaches('[data-PWA="clear-caches"]', {
        alertSuccess: "Cleared cache, reload page"
    });
});



import(/* webpackChunkName: 'toggle-theme' */ "toggle-theme")
.then(module => module.default)
.then(ThemeToggler => {
    new ThemeToggler('[data-theme-toggle]', {
        transition: 500
    });
});




//
// Install serviceworker
//
import(/* webpackChunkName: 'workbox-window' */ "workbox-window")
.then(module => module.Workbox)
.then(Workbox => {
    if ('serviceWorker' in navigator) {
        const wb = new Workbox('/assets/serviceworker.js', {
            scope: "/",
            // type: "module"
        });

        // Handling service worker updates with immediacy
        // Article: https://developer.chrome.com/docs/workbox/handling-service-worker-updates/

        const promptForUpdate = async (msg) => {
            return new Promise(function (resolve, reject) {
                let confirmed = window.confirm(msg);
                return confirmed ? resolve(true) : reject(false);
            });
        };

        const showSkipWaitingPrompt = async (event) => {
            // Assuming the user accepted the update, set up a listener
            // that will reload the page as soon as the previously waiting
            // service worker has taken control.
            wb.addEventListener('controlling', () => {
              // At this point, reloading will ensure that the current
              // tab is loaded under the control of the new service worker.
              // Depending on your web app, you may want to auto-save or
              // persist transient state before triggering the reload.
              window.location.reload();
            });

            // When `event.wasWaitingBeforeRegister` is true, a previously
            // updated service worker is still waiting.
            // You may want to customize the UI prompt accordingly.

            // This code assumes your app has a promptForUpdate() method,
            // which returns true if the user wants to update.
            // Implementing this is app-specific; some examples are:
            // https://open-ui.org/components/alert.research or
            // https://open-ui.org/components/toast.research

            promptForUpdate("Update available for this website. Apply?")
            .then(updateAccepted => {
                wb.messageSkipWaiting();
            })
            .catch(e => {});
        };

        // Add an event listener to detect when the registered
        // service worker has installed but is waiting to activate.
        wb.addEventListener('waiting', (event) => {
          showSkipWaitingPrompt(event);
        });


        wb.addEventListener('activated', (event) => {
          // `event.isUpdate` will be true if another version of the service
          // worker was controlling the page when this version was registered.
          if (!event.isUpdate) {
            console.log('Service worker activated for the first time!');
            // If your service worker is configured to precache assets, those
            // assets should all be available now.
          }
        });

        wb.register();
    }
});

