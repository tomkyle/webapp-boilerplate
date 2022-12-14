<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use GuzzleHttp;

return array(

        'GuzzleHttp.Options' => function($dic) : array 
        {
            return array();
        },

        GuzzleHttp\Client::class => function($dic) : GuzzleHttp\Client
        {
            $guzzle_options = $dic->get('GuzzleHttp.Options');
            $ca_cert = getenv('CA_CERT');

            if ($ca_cert) {
                $guzzle_options = array_merge($guzzle_options, ['verify' => $ca_cert]);
            }

            return new GuzzleHttp\Client($guzzle_options);
        }
);
