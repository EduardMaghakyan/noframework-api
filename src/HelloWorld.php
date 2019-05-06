<?php
declare(strict_types = 1);

namespace DemoApi;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Relay\Runner;

class HelloWorld
{
    /**
     * @var ResponseInterface
     */
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $name     = $request->getAttribute('name');
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()->write("<html><head></head><body>Hello, {$name} world from outer space!</body></html>");

        return $response;
    }
}
