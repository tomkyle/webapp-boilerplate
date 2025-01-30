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


    /**
     * @dataProvider provideContainerDefinitionFiles
     */
    public function testContainerDefinitions( string $inc_file ) : void
    {
        $sut = require __DIR__ . '/../../core/' . $inc_file;

        $this->assertIsArray($sut);

    }

    /**
     * @return array<mixed[]>
     */
    public static function provideContainerDefinitionFiles(): array
    {
        $inc_files = [
            'actions.php',
            'app.php',
            'configs.php',
            'console.php',
            'guzzle.php',
            'middlewares.php',
            'monolog.php',
            'psr.php',
            'slim.php',
            'templating.php',
        ];
        return array_combine($inc_files, array_map(fn($c) => [ $c ], $inc_files));
    }


    /**
     * @depends testContainerDefinitions
     */
    public function testBuildingDependencyInjectionContainer(): ContainerInterface
    {
        $sut = require __DIR__ . '/../../core/container.php';

        $this->assertInstanceOf(ContainerInterface::class, $sut);

        return $sut;
    }



    public function testBuildingDotenvInstance(): \Dotenv\Dotenv
    {
        $sut = require __DIR__ . '/../../core/dotenv.php';

        $this->assertInstanceOf(\Dotenv\Dotenv::class, $sut);

        return $sut;
    }


    /**
     * @depends testBuildingDependencyInjectionContainer
     */
    public function createSlimApplication(ContainerInterface $container): \Slim\App
    {
        $sut = $container->get(\Slim\App::class);

        $this->assertInstanceOf(\Slim\App::class, $sut);

        return $sut;
    }
}
