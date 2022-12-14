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
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Twig\Environment as Twig;

class JsonResponse implements RequestHandlerInterface
{
    /**
     * @var mixed[]
     */
    protected $data = array();

    /**
     * @var integer
     */
    protected $json_options = 0;

    /**
     * @var string
     */
    public $content_type = 'application/json';

    /**
     * @var \Psr\Http\Message\ResponseFactoryInterface
     */
    public $response_factory;


    /**
     * @param mixed[] $data Data for JSON response
     */
    public function __construct(array $data)
    {
        $this->setData($data);
    }


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->response_factory->createResponse();
        return $this->populateResponse($request, $response);
    }


    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->populateResponse($request, $response);
    }



    protected function populateResponse(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $json_string = json_encode($this->data, $this->json_options | \JSON_THROW_ON_ERROR);
        $response->getBody()->write($json_string);

        $response = $response->withHeader('Content-Type', $this->content_type);
        return $response;
    }




    public function setResponseFactory(ResponseFactoryInterface $response_factory): self
    {
        $this->response_factory = $response_factory;
        return $this;
    }

    public function setContentType(string $content_type): self
    {
        $this->content_type = $content_type;
        return $this;
    }

    /**
     * @param mixed[] $data Data for JSON response
     */
    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function setJsonOptions(int $options): self
    {
        $this->json_options = $options;
        return $this;
    }
}
