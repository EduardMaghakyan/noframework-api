<?php
declare(strict_types=1);

namespace DemoApi;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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
        $response = $this->response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['name' => $request->getAttribute('name')]));

        return $response;
    }
}
