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
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Depends;

class ContainerTest extends \PHPUnit\Framework\TestCase
{
    use LoggerTrait;

    public function testContainerCreation(): ContainerInterface
    {
        $sut = require __DIR__ . '/../../core/container.php';
        $this->assertInstanceOf(ContainerInterface::class, $sut);

        return $sut;
    }


    #[Depends('testContainerCreation')]
    #[DataProvider('provideMostImportantClassNames')]
    public function testInstantiationOfImportantThings(string $php_class, ContainerInterface $container): void
    {
        $result = $container->get($php_class);
        $this->assertInstanceOf($php_class, $result);
    }


    /**
     * @return array<mixed[]>
     */
    public static function provideMostImportantClassNames(): array
    {
        $classes = [
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
        ];
        return array_combine($classes, array_map(static fn($c) => [ $c ], $classes));
    }
}
