---
title: Running tests
---

[server-config](server-config.md)


> **Heads up!**
>
> I am new to this GutHub pages thingy and still learning. For now, do not take this docs too seriously, rather stick with [README.md](../README.md)

---

# Running tests

This packages has predefined test setups for code quality, code readability and style, unit/integration tests, and frontend performance. Check them out at the **scripts** sections of **[composer.json](./composer.json)** and **[package.json](./package.json)**. 


## PhpStan

Default configuration is **[phpstan.neon.dist](./phpstan.neon.dist).** Create a custom **phpstan.neon** to apply your own settings. Also visit [phpstan.org](https://phpstan.org/) · [GitHub](https://github.com/phpstan/phpstan) · [Packagist](https://packagist.org/packages/phpstan/phpstan)

```bash
$ composer phpstan

# which includes
$ phpstan analyse
```

## PHP-CS

Default configuration is **[.php-cs-fixer.dist.php](./.php-cs-fixer.dist.php).** Create a custom **.php-cs-fixer.php** to apply your own settings. Also visit [cs.symfony.com](https://cs.symfony.com/) ·  [GitHub](https://github.com/FriendsOfPHP/PHP-CS-Fixer) · [Packagist](https://packagist.org/packages/friendsofphp/php-cs-fixer)

```bash
$ composer phpcs
$ composer phpcs:apply
```

## PHPUnit and integration tests

Default configuration is **[phpunit.xml.dist](./phpunit.xml.dist).** Create a custom **phpunit.xml** to apply your own settings. 
Also visit [phpunit.readthedocs.io](https://phpunit.readthedocs.io/) · [Packagist](https://packagist.org/packages/phpunit/phpunit)

```bash
$ composer test

# which includes these two:
$ composer test:unit
$ composer test:integration
```

## Frontend performance

Default configuration is **[lighthouserc.js](./lighthouserc.js).** Before running [Lighthouse CI](https://github.com/GoogleChrome/lighthouse-ci) on the Docker machine, a production build is triggered. Test results will go locally in **./tests/lhci** directory. Visit [lhci docs](https://www.npmjs.com/package/@lhci/cli) · [Google's Lighthouse](https://developers.google.com/web/tools/lighthouse/)

```bash
$ npm run lighthouse
# Alias for
$ npx lhci autorun lighthouserc.js
```

## Postman API testing

[Postman](https://www.postman.com/) users import the requests **collection.json** from the **resources/postman** directory. All requests are prefixed with a `{{LOCALHOST}}` variable; either [set its value in Postman](https://learning.postman.com/docs/sending-requests/variables/#defining-variables) or replace the whole string with a text editor. 
