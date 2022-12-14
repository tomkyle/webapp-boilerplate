#!/usr/bin/env php
<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Commands;

$root_path  = dirname(__DIR__);
require_once $root_path . '/vendor/autoload.php';


$silly = new \Silly\Application();

$silly->command(
    'dotenv [--yes]',
    new Commands\SillyCreateCustomFileFromDist($silly, "env.dist", ".env")
)->descriptions('Create dotenv file if neccessary.', [
    '--yes' => 'Create file, do not ask',
]);


$silly->command(
    'htaccess [--yes]',
    new Commands\SillyCreateCustomFileFromDist($silly, 'public/htaccess.dist', 'public/.htaccess')
)->descriptions('Create .htaccess file if neccessary.', [
    '--yes' => 'Create file, do not ask',
]);


$old_cwd = getcwd();
chdir($root_path);

$silly->run();

if ($old_cwd !== false) {
    chdir($old_cwd);
}
