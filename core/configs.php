<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use Germania\ConfigReader;

return array(

    ConfigReader\ConfigReaderInterface::class => function ($dic): ConfigReader\ConfigReaderInterface {
        return $dic->get(ConfigReader\YamlConfigReader::class);
    },

    ConfigReader\YamlConfigReader::class => function ($dic): callable {
        $path = dotenv('CONFIGS_DIR');
        $reader = new ConfigReader\YamlConfigReader($path);
        $reader->setIgnoreKey("_ignore");

        return $reader;
    }

);
