<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use Dotenv\Dotenv;

// For we are in a sub-directory ...
$root_path  = dirname(__DIR__);
$_ENV[ "BASE_DIR" ] = $root_path;


// Setup Dotenv
$dotenv = Dotenv::createImmutable($root_path);
$dotenv->load();
// $dotenv->safeLoad();


// Plausibilty checks
$dotenv->required([
    'IS_DEVELOPMENT',
    'PHP_ERROR_REPORTING',

    'CONFIGS_DIR',
    'TEMPLATES_DIR',
    'TEMPLATES_CACHE',
    'VAR_DIR',
    'PEM_DIR',
    'CACHE_DIR',

    'CACHE_LIFETIME',

    'LOG_NAME',
    'LOG_LEVEL',
    'LOG_FILE',
])->notEmpty();


$dotenv->required([
    'IS_DEVELOPMENT'
])->isBoolean();


$dotenv->required([
    'CA_CERT'
]);


return $dotenv;
