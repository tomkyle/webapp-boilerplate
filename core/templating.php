<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use Twig;

return array(

    'Templates.Directory' => function (): string {
        return dotenv('TEMPLATES_DIR');
    },

    'Templates.Cache' => function (): string {
        return dotenv('TEMPLATES_CACHE') ?: sys_get_temp_dir();
    },

    'Twig.Environment.Options' => function ($dic): array {
        $is_dev    = (bool) dotenv('IS_DEVELOPMENT');
        $cache_dir = $dic->get('Templates.Cache');
        $options   = $dic->get('App.Twig')['environmentOptions'];

        $options['debug']            = $options['debug']            ?? $is_dev;
        $options['auto_reload']      = $options['auto_reload']      ?? $is_dev;
        $options['strict_variables'] = $options['strict_variables'] ?? $is_dev;
        $options['cache']            = $cache_dir;

        return $options;
    },

    Twig\Environment::class => function ($dic): Twig\Environment {
        $loader  = $dic->get(Twig\Loader\LoaderInterface::class);
        $options = $dic->get('Twig.Environment.Options');

        $twig = new Twig\Environment($loader, $options);

        $is_dev = (bool) dotenv('IS_DEVELOPMENT');
        if ($is_dev) {
            $twig->addExtension(new Twig\Extension\DebugExtension()) ;
        }

        return $twig;
    },



    Twig\Loader\LoaderInterface::class => function ($dic): Twig\Loader\LoaderInterface {
        return $dic->get(Twig\Loader\FilesystemLoader::class);
    },



    Twig\Loader\FilesystemLoader::class => function ($dic): Twig\Loader\FilesystemLoader {
        $loader = new Twig\Loader\FilesystemLoader();

        $templates_dir = $dic->get('Templates.Directory');

        $loader->addPath($templates_dir);

        $namespaces = $dic->get('App.Twig')['templateNamespaces'];
        foreach ($namespaces as $namespace => $subdir) {
            $loader->addPath($templates_dir . $subdir, $namespace);
        }

        return $loader;
    },


);
