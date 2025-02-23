<?php

/**
 * PHP Slim4 Web App Boilerplate (https://github.com/tomkyle/webapp-boilerplate)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Actions;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteContext;
use Slim\Interfaces\RouteInterface;
use Twig;

class TwigRequestHandler implements RequestHandlerInterface
{
    /**
     * @var \Twig\Environment
     */
    public $twig;


    /**
     * @var \Psr\Http\Message\ResponseFactoryInterface
     */
    public $response_factory;


    /**
     * @var string
     */
    public $template = "website.tpl";

    /**
     * @var string
     */
    public $content_type = 'text/html';

    /**
     * @var mixed[]
     */
    public $default_context = [];


    public function __construct(ResponseFactoryInterface $responseFactory, Twig\Environment $twigEnvironment)
    {
        $this->setResponseFactory($responseFactory);
        $this->setTwigEnvironment($twigEnvironment);
    }


    public function handle(ServerRequestInterface $serverRequest): ResponseInterface
    {
        // Evaluate route
        $route = RouteContext::fromRequest($serverRequest)->getRoute();
        if (!$route instanceof RouteInterface) {
            throw new \UnexpectedValueException("getRoute did not return RouteInterface");
        }

        $route_arguments = $route->getArguments();

        // Build template context array
        $context = array_merge($this->default_context, $route_arguments);
        $template = $context['template'] ?? $this->template;

        $rendered = $this->twig->render($template, $context);

        $response = $this->response_factory->createResponse();
        $response->getBody()->write($rendered);

        return $response->withHeader('Content-Type', $this->content_type);
    }


    /**
     * @param mixed[] $default_context Variables context for templates
     */
    public function setDefaultContext(array $default_context): self
    {
        $this->default_context = $default_context;
        return $this;
    }

    public function setTwigEnvironment(Twig\Environment $twigEnvironment): self
    {
        $this->twig = $twigEnvironment;
        return $this;
    }

    public function setContentType(string $content_type): self
    {
        $this->content_type = $content_type;
        return $this;
    }

    public function setResponseFactory(ResponseFactoryInterface $responseFactory): self
    {
        $this->response_factory = $responseFactory;
        return $this;
    }

    public function setTemplate(string $template): self
    {
        $this->template = $template;
        return $this;
    }
}
