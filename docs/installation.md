
**[Back to Index](index.md)**

---

# Installation

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

## After successful installation

1. Composer will automatically run the **bin/post-install.php** script which, if necessary, creates a **.env** file and a **public/.htaccess**, based on their respective *dist* template files.
2. Open **.env** and **public/.htaccess** in your editor and adapt to your needs.
3. Edit **public/robots.txt** and change *sitemap* URL.
4. **On development environment:** 
	- Setup the SSL certificates for the Docker container. See section below. 
	- Also edit the source file header in **.php-cs-fixer.dist.php** 

