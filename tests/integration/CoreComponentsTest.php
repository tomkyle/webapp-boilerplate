<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Integration;

use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerInterface;

class CoreComponentsTest extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;



    public function testBuildingDotenvInstance(): \Dotenv\Dotenv
    {
        $sut = require __DIR__ . '/../../core/dotenv.php';

        $this->assertInstanceOf(\Dotenv\Dotenv::class, $sut);

        return $sut;
    }

    public function testBuildingDependencyInjectionContainer(): ContainerInterface
    {
        $sut = require __DIR__ . '/../../core/container.php';

        $this->assertInstanceOf(ContainerInterface::class, $sut);

        return $sut;
    }
}
