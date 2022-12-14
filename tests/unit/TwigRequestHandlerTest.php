<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Unit;

use App\Actions\TwigRequestHandler;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class TwigRequestHandlerTest extends \PHPUnit\Framework\TestCase
{
    use ProphecyTrait;

    public function testInstantiation(): TwigRequestHandler
    {
        $response_factory_mock = $this->prophesize(ResponseFactoryInterface::class);
        $response_factory = $response_factory_mock->reveal();

        $twig_mock = $this->prophesize(\Twig\Environment::class);
        $twig = $twig_mock->reveal();

        $sut = new TwigRequestHandler($response_factory, $twig);

        $this->assertInstanceOf(RequestHandlerInterface::class, $sut);

        return $sut;
    }


    /**
     * @depends testInstantiation
     */
    public function testTwigEnvironmentSetter(TwigRequestHandler $sut): void
    {
        $twig_mock = $this->prophesize(\Twig\Environment::class);
        $twig = $twig_mock->reveal();

        $fluid = $sut->setTwigEnvironment($twig);
        $this->assertEquals($fluid, $sut);
    }


    /**
     * @depends testInstantiation
     */
    public function testTemplateSetter(TwigRequestHandler $sut): void
    {
        $fluid = $sut->setTemplate("website.tpl");
        $this->assertEquals($fluid, $sut);
    }


    /**
     * @depends testInstantiation
     */
    public function testContextSetter(TwigRequestHandler $sut): void
    {
        $context = array('foo' => 'bar');
        $fluid = $sut->setDefaultContext($context);
        $this->assertEquals($fluid, $sut);
        $this->assertEquals($fluid->default_context, $context);
    }


    /**
     * @depends testInstantiation
     */
    public function testResponseFactorySetter(TwigRequestHandler $sut): void
    {
        $response_factory_mock = $this->prophesize(ResponseFactoryInterface::class);
        $response_factory = $response_factory_mock->reveal();

        $fluid = $sut->setResponseFactory($response_factory);
        $this->assertEquals($fluid, $sut);
    }
}
