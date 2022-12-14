<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use DI\ContainerBuilder;
use Dotenv\Dotenv;

$builder = new ContainerBuilder();
$builder->addDefinitions([
    Dotenv::class => require __DIR__ . '/dotenv.php'
]);



// On Production environment
if (!(bool) dotenv('IS_DEVELOPMENT')) {
    $cache_path = dotenv('CACHE_DIR');
    $builder->enableCompilation($cache_path);
    $builder->writeProxiesToFile(true, $cache_path . '/proxies');
}


$services_path = __DIR__;

$builder->addDefinitions(...array(
    $services_path . '/configs.php',
    $services_path . '/console.php',
    $services_path . '/app.php',
    $services_path . '/monolog.php',
    $services_path . '/psr.php',
    $services_path . '/slim.php',
    $services_path . '/guzzle.php',
    $services_path . '/actions.php',
    $services_path . '/middlewares.php',
    $services_path . '/templating.php',
));



return $builder->build();
