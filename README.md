<h1 align="center">tomkyle/webapp-boilerplate</h1>

This is how I would start a new PHP web application on PHP 8.1+, based on [Slim 4](https://www.slimframework.com/) , Docker, Gulp, Webpack, PhpUnit, and pretty much everything I find useful.

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)

---

## Features

- Slim Framework
- Docker setup with SSL support
- PhpUnit with basic unit and integration tests 
- Composer scripts with PHP-CS and phpstan
- Gulp + Webpack for frontend workflow 
- Serviceworker and Webmanifest
- Modern favicons setup
- Content-Security-Policy configuration file
- Customizable .htaccess configuration and build tool
- Custom error pages
- Dark mode support with JS theme switcher
- Postman collection

---

## Installation

```bash
$ gh repo clone tomkyle/webapp-boilerplate
$ cd webapp-boilerplate
```

**On production environment,** install dependencies like this:

```bash
$ composer install --no-dev
```

**On development environment,** install dependencies as follows. 

```bash
$ composer install
$ npm install
```

### After successful installation

1. Composer will automatically run the **bin/post-install.php** script which, if necessary, creates a **.env** file and a **public/.htaccess**, based on their respective *dist* template files.
2. Open **.env** and **public/.htaccess** in your editor and adapt to your needs.
3. Edit **public/robots.txt** and change *sitemap* URL.
4. **On development environment:** 
	- Setup the SSL certificates for the Docker container. See section below. 
	- Also edit the source file header in **.php-cs-fixer.dist.php** 

---

## Docker container

### Prepare SSL certificates

The Apache webserver inside the docker container requires  `*.pem` development certificates for its SSL engine. Create those and store them in **resources/docker/ssl/** directory.

> A good tool for creating locally trusted development certificates is Filippo Valsorda's **[mkcert](https://github.com/FiloSottile/mkcert)**. It is available for MacOS, Linux, and Windows; follow the docs over on GitHub on how to [install mkcert](https://github.com/FiloSottile/mkcert#installation).

```bash
$ cd resources/docker/ssl
$ mkcert \
-key-file localhost-key.pem \
-cert-file localhost.pem \
localhost 127.0.0.1 ::1
```

### Running Docker

You can use [`docker-compose.yml`](./docker-compose.yml) to serve on [**https://localhost/**](https://localhost/). Make sure you installed some locally trusted SSL certificates / PEM keys as described above. To turn on Docker machine:

```bash
$ docker compose up
# and somewhere else:
$ docker compose down
```

---

## Server configuration

### Building .htaccess

The **[public/htaccess.dist](./public/htaccess.dist)** distributed with the repo combines modules from the **[H5BP Apache Server Configs](https://github.com/h5bp/server-configs-apache)** and Jeff Starr's **[Perishable Press 7G Firewall](https://perishablepress.com/7g-firewall/)**.

This repo uses a *[.htaccess configuration file](./resources/server-configs/htaccess.conf)* located in the **server-configs** directory. This kind of file is described on the [H5BP Apache Server Configs](https://github.com/h5bp/server-configs-apache) project site. Have a look at their docs on how to tweak your *.htaccess* file.

To build a new **public/htaccess.dist** file:

```bash
$ composer htaccess
$ cp public/htaccess.dist public/.htaccess
```

### Custom error pages / ErrorDocument

Do not forget to edit or add your contact data to the HTML files inside the **public/errordocs/** directory. To disable custom error documents, look inside the *[.htaccess configuration file](./resources/server-configs/htaccess.conf)* – you'll find this line:

```text
enable  "resources/server-configs/custom-errorpages.conf"
```

Simply change to `disable …` and rebuild the *.htaccess.* 

### Content-Security-Policy

The web app uses [\Middlewares\CSP middleware](https://github.com/middlewares/csp) for certain routes. The value of the CSP header can be defined in **[configs/csp.dist.yaml](./configs/csp.dist.yaml)** (or *configs/csp.yaml,* respectively).

**The distributed csp.dist.yaml** creates the same CSP headers than those used in the [H5BP Apache Server Configs](https://github.com/h5bp/server-configs-apache) project. Head over to their original content-security snippet: [content-security-policy.conf](https://github.com/h5bp/server-configs-apache/blob/main/h5bp/security/content-security-policy.conf)

---

## Command Line Interface

### **General information**

```bash
$ bin/console list
$ bin/console help
```

### **Update website from repo**

Pull the latest stuff from repo; install dependencies without the development stuff.

```
$ git pull
$ bin/console install --no-dev
$ bin/console install --no-dev -v
```

------

## Frontend development

### Gulp and Webpack

The `npx` command will use *local* or *global* Gulp CLI. Watch file changes and build assets like so:

```bash
$ npx gulp watch
$ NODE_ENV=production npx gulp watch
```

### Development builds

```bash
$ npm run dev
# Alias for
$ npx gulp && npx workbox-cli injectManifest
```
### Production builds

```bash
$ npm run build
# Alias for
$ NODE_ENV=production npx gulp && NODE_ENV=production npx workbox-cli injectManifest
```


### Building Favicons

This feature uses [svgexport](https://www.npmjs.com/package/svgexport) and [imagemagick's](https://www.npmjs.com/package/imagemagick) convert to create various PNG favicons and a traditional ICO file.

1. Put a new SVG favicon `favicon.svg` into the **public/favicons** directory
2. Run build script to create several **PNG favicons** as well as a **favicon.ico** file:

```bash
$ bin/favicons
```

---

## Running tests

This packages has predefined test setups for code quality, code readability and style, unit/integration tests, and frontend performance. Check them out at the **scripts** sections of **[composer.json](./composer.json)** and **[package.json](./package.json)**. 

### PhpStan

Default configuration is **[phpstan.neon.dist](./phpstan.neon.dist).** Create a custom **phpstan.neon** to apply your own settings. Also visit [phpstan.org](https://phpstan.org/) · [GitHub](https://github.com/phpstan/phpstan) · [Packagist](https://packagist.org/packages/phpstan/phpstan)

```bash
$ composer phpstan

# which includes
$ phpstan analyse
```

### PHP-CS

Default configuration is **[.php-cs-fixer.dist.php](./.php-cs-fixer.dist.php).** Create a custom **.php-cs-fixer.php** to apply your own settings. Also visit [cs.symfony.com](https://cs.symfony.com/) ·  [GitHub](https://github.com/FriendsOfPHP/PHP-CS-Fixer) · [Packagist](https://packagist.org/packages/friendsofphp/php-cs-fixer)

```bash
$ composer phpcs
$ composer phpcs:apply
```

### PHPUnit and integration tests

Default configuration is **[phpunit.xml.dist](./phpunit.xml.dist).** Create a custom **phpunit.xml** to apply your own settings. 
Also visit [phpunit.readthedocs.io](https://phpunit.readthedocs.io/) · [Packagist](https://packagist.org/packages/phpunit/phpunit)

```bash
$ composer test

# which includes these two:
$ composer test:unit
$ composer test:integration
```

### Frontend performance

Default configuration is **[lighthouserc.js](./lighthouserc.js).** Before running [Lighthouse CI](https://github.com/GoogleChrome/lighthouse-ci) on the Docker machine, a production build is triggered. Test results will go locally in **./tests/lhci** directory. Visit [lhci docs](https://www.npmjs.com/package/@lhci/cli) · [Google's Lighthouse](https://developers.google.com/web/tools/lighthouse/)

```bash
$ npm run lighthouse
# Alias for
$ npx lhci autorun lighthouserc.js
```

### Postman API testing

[Postman](https://www.postman.com/) users import the requests **collection.json** from the **resources/postman** directory. All requests are prefixed with a `{{LOCALHOST}}` variable; either [set its value in Postman](https://learning.postman.com/docs/sending-requests/variables/#defining-variables) or replace the whole string with a text editor. 

---

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
