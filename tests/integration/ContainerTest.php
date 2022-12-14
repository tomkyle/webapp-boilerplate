<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Integration;

use tests\LoggerTrait;
use Psr\Container\ContainerInterface;

class ContainerTest extends \PHPUnit\Framework\TestCase
{
    use LoggerTrait;

    public function testContainerCreation(): ContainerInterface
    {
        $sut = require __DIR__ . '/../../core/container.php';
        $this->assertInstanceOf(ContainerInterface::class, $sut);

        return $sut;
    }


    /**
     * @dataProvider provideMostImportantClassNames
     * @depends testContainerCreation
     */
    public function testInstantiationOfImportantThings(string $php_class, ContainerInterface $sut): void
    {
        $result = $sut->get($php_class);
        $this->assertInstanceOf($php_class, $result);
    }


    /**
     * @return array<mixed[]>
     */
    public function provideMostImportantClassNames(): array
    {
        $classes = array(
            \Dotenv\Dotenv::class,
            \Psr\Log\LoggerInterface::class,
            \Germania\ConfigReader\ConfigReaderInterface::class,
            \Psr\Http\Client\ClientInterface::class,
            \Psr\Http\Message\RequestFactoryInterface::class,
            \Psr\Http\Message\ResponseFactoryInterface::class,
            \Psr\Http\Message\UriFactoryInterface::class,
            \Psr\Http\Message\ServerRequestFactoryInterface::class,
            \Psr\Http\Message\ServerRequestInterface::class,
            \Slim\App::class,
            \Twig\Environment::class,
            \Symfony\Component\Console\Application::class
        );
        return array_combine($classes, array_map(function ($c) {
            return [ $c ];
        }, $classes));
    }
}
