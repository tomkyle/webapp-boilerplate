<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use Germania\ConfigReader;
use Psr\Http\Message\ServerRequestInterface;

/**
 * DI definitions for Application
 */

return array(


    'App.Config' => function ($dic): array {
        $config_reader = $dic->get(ConfigReader\ConfigReaderInterface::class);

        return $config_reader("app.dist.yaml", "app.yaml") ?? array();
    },


    'App.BaseUrl' => function ($dic): string {
        $request_uri = $dic->get(ServerRequestInterface::class)->getUri();
        $base_url_path = dotenv('SLIM_BASE_PATH');

        $base_url = preg_replace("/\/$/", "", $request_uri->withPath($base_url_path)->withQuery("")->__toString());
        return $base_url;
    },


    'App.CanonicalUrl' => function ($dic): string {
        return $dic->get(ServerRequestInterface::class)->getUri()->withQuery("")->__toString();
    },


    'App.Middlewares' => function ($dic): array {
        $config = $dic->get('App.Config');
        $middlewares = $config['middlewares'] ?? array() ?: array();

        return $middlewares ?: array();
    },


    'App.Twig' => function ($dic): array {
        $config = $dic->get('App.Config');
        return $config['twig'] ?? array() ?: array();
    },


    'App.Matomo' => function ($dic): array {
        $config = $dic->get('App.Config');
        return $config['matomo'] ?? array() ?: array();
    },


    'App.Monolog' => function ($dic): array {
        $config = $dic->get('App.Config');
        return $config['monolog'] ?? array() ?: array();
    },


    'App.DefaultContext' => function ($dic): array {
        return array(
            'matomo'        => $dic->get('App.Matomo'),
            'baseUrl'       => $dic->get('App.BaseUrl')
        );
    },


    'App.Routes' => function ($dic): array {
        $config = $dic->get('App.Config');
        $route_definitions = $config['routeDefinitions'] ?? array();
        $config_reader = $dic->get(ConfigReader\ConfigReaderInterface::class);

        return $config_reader(...$route_definitions) ?? array();
    },

    'App.Sitemap.Routes' => function ($dic): array {
        $all_routes = $dic->get('App.Routes');

        return array_map(function ($sr) {
            $sr['sitemap'] = is_bool($sr['sitemap']) ? 0.5 : $sr['sitemap'];
            return $sr;
        }, array_filter($all_routes, function ($route) {
            return $route['sitemap'] ?? false;
        }));
    },


    'App.Webmanifest' => function ($dic): array {
        $config = $dic->get('App.Config');
        $manifest = $config['webmanifest'] ?? array();

        return $manifest;
    },


    'App.utilityDirectories' => function ($dic): array {
        return array(
            'var'        => dotenv('VAR_DIR'),
            'cache'      => dotenv('CACHE_DIR'),
            'templates'  => dotenv('TEMPLATES_CACHE')
        );
    },

    'App.cacheDirectories' => function ($dic): array {
        return array(
            'cache'      => dotenv('CACHE_DIR'),
            'templates'  => dotenv('TEMPLATES_CACHE')
        );
    },



);
