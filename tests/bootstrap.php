<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$root_path = dirname(__DIR__);
$autoloader = $root_path . '/vendor/autoload.php';
if (!is_readable($autoloader)) {
    die(sprintf("\nMissing Composer's Autoloader '%s'; Install Composer dependencies first.\n\n", $autoloader));
}

