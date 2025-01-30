<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Unit;

use App\Actions\JsonResponse;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class JsonResponseTest extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;


    public function testInstantiation(): JsonResponse
    {
        $jsonResponse = new JsonResponse([]);

        $this->assertInstanceOf(RequestHandlerInterface::class, $jsonResponse);

        return $jsonResponse;
    }


    /**
     * @depends testInstantiation
     */
    public function testDataSetter(JsonResponse $jsonResponse): void
    {
        $fluid = $jsonResponse->setData([]);
        $this->assertEquals($fluid, $jsonResponse);
    }


    /**
     * @depends testInstantiation
     */
    public function testJsonOptionsSetter(JsonResponse $jsonResponse): void
    {
        $fluid = $jsonResponse->setJsonOptions(0);
        $this->assertEquals($fluid, $jsonResponse);
    }


    /**
     * @depends testInstantiation
     */
    public function testContentTypeSetter(JsonResponse $jsonResponse): void
    {
        $fluid = $jsonResponse->setContentType('application/manifest+json');
        $this->assertEquals($fluid, $jsonResponse);
    }



    /**
     * @depends testInstantiation
     */
    public function testResponseFactorySetter(JsonResponse $jsonResponse): void
    {
        $objectProphecy = $this->prophesize(ResponseFactoryInterface::class);
        $responseFactory = $objectProphecy->reveal();

        $fluid = $jsonResponse->setResponseFactory($responseFactory);
        $this->assertEquals($fluid, $jsonResponse);
    }
}
