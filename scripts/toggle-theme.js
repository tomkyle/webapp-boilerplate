
// Instantiation:
//
//     new ThemeToggler('[data-theme-toggle]', {
//         transition: 500
//     });
//
//
// Recommendation: Add this to your HTML head:
//
//    <script>
//    const theme = localStorage.getItem('theme');
//    if (theme) { document.documentElement.classList.add(theme); }
//    </script>

var ThemeToggler = function(toggleThemeSelector, options)
{
    this.settings = Object.assign({
        toggleThemeSelector: toggleThemeSelector,
        rootElt: document.documentElement,
        transition: 0,
        localStorageId: "theme"
    }, options || {});

    var allToggleButtons = document.querySelectorAll(toggleThemeSelector);

    this.availableThemes  = Array.from(allToggleButtons)
                           .map(btn => btn.dataset.themeToggle)
                           .filter((value, index, self) => (self.indexOf(value) === index));


    // Get the user's theme preference from local storage, if it's available
    const storedTheme = localStorage.getItem( this.settings.localStorageId );
    console.log(`Stored theme: ${storedTheme}`);

    // If theme preference was found and not applied already
    if (storedTheme && !this.settings.rootElt.classList.contains(storedTheme)) {
        this.toggleTheme(storedTheme, false);
    }


    document.addEventListener('click', e => {
        if (!e.target.matches( this.settings.toggleThemeSelector )) return;
        e.preventDefault();

        var newTheme = e.target.dataset.themeToggle,
            storeThisTheme = this.toggleTheme(newTheme, true) ? newTheme : null;

        console.log(`Store in localStorage: ${storeThisTheme}`);
        localStorage.setItem(this.settings.localStorageId, storeThisTheme);
    });

};

ThemeToggler.prototype = {

    toggleTheme : function(newTheme, withTransition ) {
        this.availableThemes.forEach((theme) => {
            if (newTheme !== theme)
                this.settings.rootElt.classList.remove(theme);
        });
        console.log(`Toggle theme: ${newTheme}`);

        if (this.settings.transition && withTransition ) {
            this.settings.rootElt.classList.add('color-theme-in-transition')
            window.setTimeout(function() {
              this.settings.rootElt.classList.remove('color-theme-in-transition')
            }.bind(this), this.settings.transition);
        }

        return this.settings.rootElt.classList.toggle(newTheme);
    }
}


export default ThemeToggler;
