<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Actions;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use function App\dotenv;

return array(

    TwigRequestHandler::class => function ($dic): TwigRequestHandler {
        $twig = $dic->get(\Twig\Environment::class);
        $response_factory = $dic->get(ResponseFactoryInterface::class);
        $context = $dic->get('App.DefaultContext');

        return (new TwigRequestHandler($response_factory, $twig))
            ->setDefaultContext($context);
    },

    /* @phpstan-ignore-next-line as this class name is fictive */
    Webmanifest::class => function ($dic): JsonResponse {
        $manifest = $dic->get('App.Webmanifest');
        $options = dotenv('IS_DEVELOPMENT') ? \JSON_PRETTY_PRINT : 0;
        $response_factory = $dic->get(ResponseFactoryInterface::class);

        return (new JsonResponse($manifest))
            ->setJsonOptions($options)
            ->setContentType('application/manifest+json')
            ->setResponseFactory($response_factory);
    },

    /* @phpstan-ignore-next-line as this class name is fictive */
    Sitemap::class => function ($dic): RequestHandlerInterface {
        $routes = $dic->get('App.Sitemap.Routes');

        $handler = $dic->get(TwigRequestHandler::class)
            ->setDefaultContext([
                'baseUrl' => $dic->get('App.BaseUrl'),
                'items' => $routes
            ])
            ->setContentType('application/xml');

        return $handler;
    },
);
