<h1 align="center">tomkyle/webapp-boilerplate</h1>

This is how I would start a new PHP web application on PHP 8.3+, based on [Slim 4](https://www.slimframework.com/) , Docker, Gulp, Webpack, PhpUnit, and pretty much everything I find useful.

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
```

## Documentation

- [More on Installation](https://tomkyle.github.io/webapp-boilerplate/installation.html)
- [Prepare and use Docker container](https://tomkyle.github.io/webapp-boilerplate/docker.html)
- [Setup Apache server configuration](https://tomkyle.github.io/webapp-boilerplate/server-config.html)
- [Frontend development](https://tomkyle.github.io/webapp-boilerplate/frontend.html)
- [Unit tests and Code analysis](https://tomkyle.github.io/webapp-boilerplate/testing.html)

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
