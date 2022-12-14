var PwaClearCaches = function(triggerSelector, options)
{
    this.settings = Object.assign({
        triggerSelector: triggerSelector,
        alertSuccess: null,
    }, options || {});


    document.addEventListener('click', e => {
        if (!e.target.matches(this.settings.triggerSelector)) return;
        e.preventDefault();
        this.deleteCaches().then(function() {
            if (this.settings.alertSuccess)
                alert(this.settings.alertSuccess);
            window.location.reload();
        }.bind(this));
    });
};


PwaClearCaches.prototype = {

    deleteCaches : async function( evt ) {
      try {
        const keys = await window.caches.keys();
        await Promise.all(keys.map(key => caches.delete(key)));
      } catch (err) {
        console.error('Deleting caches failed: ', err);
      }
    }


};

export default PwaClearCaches;
