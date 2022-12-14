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
        $sut = new JsonResponse(array());

        $this->assertInstanceOf(RequestHandlerInterface::class, $sut);

        return $sut;
    }


    /**
     * @depends testInstantiation
     */
    public function testDataSetter(JsonResponse $sut): void
    {
        $fluid = $sut->setData(array());
        $this->assertEquals($fluid, $sut);
    }


    /**
     * @depends testInstantiation
     */
    public function testJsonOptionsSetter(JsonResponse $sut): void
    {
        $fluid = $sut->setJsonOptions(0);
        $this->assertEquals($fluid, $sut);
    }


    /**
     * @depends testInstantiation
     */
    public function testContentTypeSetter(JsonResponse $sut): void
    {
        $fluid = $sut->setContentType('application/manifest+json');
        $this->assertEquals($fluid, $sut);
    }



    /**
     * @depends testInstantiation
     */
    public function testResponseFactorySetter(JsonResponse $sut): void
    {
        $response_factory_mock = $this->prophesize(ResponseFactoryInterface::class);
        $response_factory = $response_factory_mock->reveal();

        $fluid = $sut->setResponseFactory($response_factory);
        $this->assertEquals($fluid, $sut);
    }
}
