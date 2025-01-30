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
        $objectProphecy = $this->prophesize(ResponseFactoryInterface::class);
        $responseFactory = $objectProphecy->reveal();

        $twig_mock = $this->prophesize(\Twig\Environment::class);
        $twigEnvironment = $twig_mock->reveal();

        $twigRequestHandler = new TwigRequestHandler($responseFactory, $twigEnvironment);

        $this->assertInstanceOf(RequestHandlerInterface::class, $twigRequestHandler);

        return $twigRequestHandler;
    }


    /**
     * @depends testInstantiation
     */
    public function testTwigEnvironmentSetter(TwigRequestHandler $twigRequestHandler): void
    {
        $objectProphecy = $this->prophesize(\Twig\Environment::class);
        $twigEnvironment = $objectProphecy->reveal();

        $fluid = $twigRequestHandler->setTwigEnvironment($twigEnvironment);
        $this->assertEquals($fluid, $twigRequestHandler);
    }


    /**
     * @depends testInstantiation
     */
    public function testTemplateSetter(TwigRequestHandler $twigRequestHandler): void
    {
        $fluid = $twigRequestHandler->setTemplate("website.tpl");
        $this->assertEquals($fluid, $twigRequestHandler);
    }


    /**
     * @depends testInstantiation
     */
    public function testContextSetter(TwigRequestHandler $twigRequestHandler): void
    {
        $context = ['foo' => 'bar'];
        $fluid = $twigRequestHandler->setDefaultContext($context);
        $this->assertEquals($fluid, $twigRequestHandler);
        $this->assertEquals($fluid->default_context, $context);
    }


    /**
     * @depends testInstantiation
     */
    public function testResponseFactorySetter(TwigRequestHandler $twigRequestHandler): void
    {
        $objectProphecy = $this->prophesize(ResponseFactoryInterface::class);
        $responseFactory = $objectProphecy->reveal();

        $fluid = $twigRequestHandler->setResponseFactory($responseFactory);
        $this->assertEquals($fluid, $twigRequestHandler);
    }
}
