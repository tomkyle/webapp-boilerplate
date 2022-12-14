<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use Middlewares;
use Germania\ConfigReader;
use Psr\Http\Server\MiddlewareInterface;

return [



    'App.Middlewares' => function ($dic): array {
        $config = $dic->get('App.Config');
        return $config['appMiddlewares'] ?? array();
    },



    'ContentSecurityPolicy.Config' => function ($dic): array {
        $config = $dic->get(ConfigReader\ConfigReaderInterface::class)("csp.dist.yaml", "csp.yaml");
        return $config;
    },


    \ParagonIE\CSPBuilder\CSPBuilder::class => function ($dic): \ParagonIE\CSPBuilder\CSPBuilder {
        $config = $dic->get('ContentSecurityPolicy.Config');
        return new \ParagonIE\CSPBuilder\CSPBuilder($config);
    },


    /**
     * @return Middlewares\Csp
     */
    Middlewares\Csp::class => function ($dic): MiddlewareInterface {
        $csp = $dic->get(\ParagonIE\CSPBuilder\CSPBuilder::class);

        return new Middlewares\Csp($csp);
    },


];
