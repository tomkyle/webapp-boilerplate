<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use Psr\Http\Message as PsrHttpMessage;
use Psr\Http\Client as PsrHttpClient;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Factory;

return array(


    LoggerInterface::class => function ($dic) : LoggerInterface {
        return $dic->get(\Monolog\Logger::class);
    },


    PsrHttpMessage\RequestFactoryInterface::class => function (): PsrHttpMessage\RequestFactoryInterface {
        return new Factory\RequestFactory();
    },

    PsrHttpMessage\ResponseFactoryInterface::class => function (): PsrHttpMessage\ResponseFactoryInterface {
        return new Factory\ResponseFactory();
    },

    PsrHttpMessage\UriFactoryInterface::class => function (): PsrHttpMessage\UriFactoryInterface {
        return new Factory\UriFactory();
    },

    PsrHttpMessage\ServerRequestFactoryInterface::class => function (): PsrHttpMessage\ServerRequestFactoryInterface {
        return new Factory\ServerRequestFactory();
    },

    PsrHttpMessage\ServerRequestInterface::class => function (): PsrHttpMessage\ServerRequestInterface {
        return Factory\ServerRequestFactory::createFromGlobals();
    },

    PsrHttpClient\ClientInterface::class => function ($dic): PsrHttpClient\ClientInterface {
        return $dic->get(\GuzzleHttp\Client::class);
    }

);
