<?php
declare(strict_types=1);

namespace DemoApi\Controller;


use DemoApi\Application\Dto\ProductDto;
use DemoApi\Application\ProductService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class GetAllProducts
{
    /**
     * @var ProductService
     */
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Handles a request and produces a response.
     *
     * May call other collaborating code to generate the response.
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(array_map(function (ProductDto $product) {
            return $product->toArray();
        }, $this->productService->getAllProducts()));
    }
}
