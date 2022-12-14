<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use function App\dotenv;

$root_path  = dirname(__DIR__);
require_once $root_path . '/vendor/autoload.php';


//
// Setup DIC
//
$dic    = require $root_path . '/core/container.php';


//
// Setup Error reporting
//
$error_reporting_value = dotenv('PHP_ERROR_REPORTING');
error_reporting($error_reporting_value);


//
// Setup Slim App
//
$app = $dic->get(\Slim\App::class);
$app->run();
