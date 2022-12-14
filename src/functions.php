<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

if (!function_exists('\App\dotenv')) {
    /**
     * Map getenv-like calls to $_ENV.
     *
     * @param  string $var     Enviroment variable name
     * @param  mixed  $default Optional: default value, defaults to `null`
     * @return mixed Enviroment variable value
     */
    function dotenv(string $var, $default = null)
    {
        return $_ENV[ $var ] ?? null;
    }
}
