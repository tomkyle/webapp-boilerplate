<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use Slim;
use Psr\Container\ContainerInterface;

return array(


    Slim\App::class => function (ContainerInterface $dic): Slim\App {

        //
        // Create Slim
        //
        Slim\Factory\AppFactory::setContainer($dic);
        $app = Slim\Factory\AppFactory::create();


        //
        // Slim Base Path
        //
        $base_path = dotenv('SLIM_BASE_PATH');
        if ($base_path) {
            $app->setBasePath($base_path);
        }


        //
        // Application middlewares
        //
        $middlewares = $dic->get('App.Middlewares');
        foreach ($middlewares as $middleware) {
            $app->add($middleware);
        }


        //
        //  The routing middleware should be added earlier than the ErrorMiddleware,
        //  otherwise exceptions thrown in routing will not be handled.
        //
        $app->addRoutingMiddleware();


        //
        // Error handling: Whoops or Slim Error middleware
        //
        // @param bool  $displayErrorDetails -> Should be set to false in production
        // @param bool  $logErrors           -> Parameter is passed to the default ErrorHandler
        // @param bool  $logErrorDetails     -> Display error details in error log
        //                                      which can be replaced by a callable of your choice.
        //
        // Note: This middleware should be added last.
        //       It will not handle any exceptions/errors
        //       for middleware added after it.

        $displayErrorDetails = (bool) dotenv('IS_DEVELOPMENT');
        $logErrors           = true;
        $logErrorDetails     = true;
        $logger              = null;

        $app->addErrorMiddleware($displayErrorDetails, $logErrors, $logErrorDetails, $logger);




        //
        // Register routes
        //
        $routes = $dic->get('App.Routes');
        foreach ($routes as $name => $page) {
            $via = (array) ($page['via'] ?? array('GET'));
            $route = $app->map($via, $page['url'], $page['action'])
                         ->setName($name)
                         ->setArguments($page['context'] ?? array());

            // Add route middleware
            foreach ($page['middlewares'] ?? array() as $middleware) {
                $route->add($middleware);
            }
        }


        return $app;
    },




);
