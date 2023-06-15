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

## Documentation

- [Docker container](https://tomkyle.github.io/webapp-boilerplate/docker.html)
- [Server configuration](https://tomkyle.github.io/webapp-boilerplate/server-config.html)
- [Frontend development](https://tomkyle.github.io/webapp-boilerplate/frontend.html)
- [Running tests](https://tomkyle.github.io/webapp-boilerplate/testing.html)

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

---

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
