<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Functional;

use tests\LoggerTrait;
use Slim\Psr7\Factory\ServerRequestFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use UnexpectedValueException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Depends;

use function App\dotenv;

class RouteResponsesTest extends \PHPUnit\Framework\TestCase
{
    use LoggerTrait;


    /**
     * Holds the app route definitions.
     *
     * @var array<mixed[]>
     */
    public static $app_routes = [];


    /**
     * @var ServerRequestFactory
     */
    public $server_request_factory;


    protected function setUp(): void
    {
        parent::setUp();
        $this->server_request_factory = new ServerRequestFactory();
    }


    public static function createApp(): \Slim\App
    {
        $_SESSION = [];
        $dic = require __DIR__ . '/../../core/container.php';
        $dic->set(LoggerInterface::class, static::getLogger());
        return $dic->get(\Slim\App::class);
    }


    /**
     * Reads the app routes from App container
     * and stores them in static class var for later use.
     *
     * @return array<mixed[]>
     */
    public static function createRoutes(): array
    {
        if (static::$app_routes !== []) {
            return static::$app_routes;
        }

        $app = static::createApp() ;
        $container = $app->getContainer();
        if (!$container instanceOf ContainerInterface) {
            throw new UnexpectedValueException("Slim app’s getContainer method did not return ContainerInterface");
        }

        $routes = $container->get('App.Routes');

        static::$app_routes = (array) $routes;

        return static::$app_routes;
    }




    /**
     * Create a server request.
     *
     * @param string $method The HTTP method
     * @param string|UriInterface $uri The URI
     * @param string[] $serverParams The server parameters
     */
    protected function createRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface
    {
        return $this->server_request_factory->createServerRequest($method, $uri, $serverParams);
    }




    /**
     * @dataProvider provideAppRoutes
     */
    #[DataProvider('provideAppRoutes')]
     public function testRouteResponse(string $url, string $via, int $status_code, string $content_type): void
    {
        // The SLIM_BASE_PATH plays a role in slim.php;
        // and must be added here
        $url = dotenv('SLIM_BASE_PATH') . $url;
        $serverRequest = $this->createRequest($via, $url);

        $app = static::createApp() ;

        try {
            $info_msg = sprintf("%s %s\nshould return %s with status %s", $via, $url, $content_type, $status_code);
            static::getLogger()->debug($info_msg);
            $response = $app->handle($serverRequest);

            $this->assertInstanceOf(ResponseInterface::class, $response);
            $this->assertEquals($status_code, $response->getStatusCode());
            $this->assertEquals($content_type, $response->getHeaderLine('Content-Type'));
        } catch (\Slim\Exception\HttpNotFoundException) {
            $msg = sprintf("Not found: %s %s\n", $via, $serverRequest->getUri()->__toString());
            static::getLogger()->error($msg);
        }
    }


    /**
     * @return array<mixed[]>
     */
    public static function provideAppRoutes(): array
    {
        $routes = static::createRoutes() ;

        $data_provider = [];
        foreach ($routes as $route_name => $route) {
            $route_fixtures = ($route['testFixtures'] ?? []) ?: [];

            if (empty($route_fixtures)) {
                $url = $route['url'];
                $via = is_array($route['via']) ? $route['via'][0] : $route['via'];
                $status = 200;
                $content_type = 'text/html';

                $fixture_label = sprintf("Route '%s' should return %s with status %s", $route_name, $content_type, $status);
                $data_provider[$fixture_label] = [$url, $via, $status, $content_type];

                continue;
            }

            foreach ($route_fixtures as $fixture_name => $fixture) {
                $url = $fixture['url'] ?? $route['url'];
                $via = $fixture['via'] ?? "GET";
                $status = $fixture['statusCode'] ?? 200;
                $content_type = $fixture['contentType'] ?? "text/html";

                $fixture_label = sprintf("Route '%s' w/ '%s' should return %s with status %s", $route_name, $fixture_name, $content_type, $status);

                $data_provider[$fixture_label] = [$url, $via, $status, $content_type];
            }
        }

        return $data_provider;
    }
}
