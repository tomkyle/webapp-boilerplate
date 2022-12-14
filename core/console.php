<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use App\Commands;
use Symfony\Component\Console;
use Psr\Container\ContainerInterface;
use Germania\ClearCache;
use Germania\UpdateApp;

return array(


    Console\Application::class => function (ContainerInterface $dic): Console\Application {
        $application = new Console\Application();
        $command_loader = $dic->get(Console\CommandLoader\CommandLoaderInterface::class);
        $application->setCommandLoader($command_loader);
        return $application;
    },

    Console\CommandLoader\CommandLoaderInterface::class => function (ContainerInterface $dic): Console\CommandLoader\CommandLoaderInterface {
        return $dic->get(Console\CommandLoader\ContainerCommandLoader::class);
    },

    Console\CommandLoader\ContainerCommandLoader::class => function ($dic): Console\CommandLoader\ContainerCommandLoader {
        return new Console\CommandLoader\ContainerCommandLoader($dic, [
            'install'       => Commands\InstallAppCommand::class,
            'cache:clear'   => ClearCache\ClearCacheCommand::class
        ]);
    },


    Commands\InstallAppCommand::class => function (ContainerInterface $dic): Commands\InstallAppCommand {
        $directories = $dic->get('App.utilityDirectories');
        $pem_dir = dotenv('PEM_DIR');

        return (new Commands\InstallAppCommand($directories))
            ->setCertificatesDirectory($pem_dir);
    },


    ClearCache\ClearCacheCommand::class => function (ContainerInterface $dic): ClearCache\ClearCacheCommand {
        $directories = $dic->get('App.cacheDirectories');
        $directories = array_filter($directories);
        $psr_caches = array();

        return new ClearCache\ClearCacheCommand($directories, $psr_caches);
    }
);
