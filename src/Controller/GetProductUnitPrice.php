<?php
declare(strict_types=1);

namespace DemoApi\Controller;


use DemoApi\Application\Exceptions\ProductNotFoundException;
use DemoApi\Application\Exceptions\ProductUnitPriceNotFoundException;
use DemoApi\Application\ProductService;
use DemoApi\Utils\Sanitize;
use DemoApi\Utils\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class GetProductUnitPrice
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
        if (empty($sku = $request->getAttribute('sku'))) {
            return new JsonResponse(['Required parameter "sku" is missing!'], 400);
        }

        if (empty($unit = $request->getAttribute('unit'))) {
            return new JsonResponse(['Required parameter "unit" is missing!'], 400);
        }

        if (!Validator::isValidSkuFormat($sku)) {
            return new JsonResponse(["Invalid 'sku'"], 400);
        }

        $sku = Sanitize::sanitize_string($sku);
        $unit = Sanitize::sanitize_string($unit);
        try {
            $product = $this->productService->getProductUnitPrice($sku, $unit);
            return new JsonResponse($product->toArray());
        } catch (ProductNotFoundException $e) {
            return new JsonResponse([sprintf('No product with sku: %s was found', $sku)], 404);
        } catch (ProductUnitPriceNotFoundException $e) {
            return new JsonResponse([sprintf('No unit price found for sku: %s , unit: %s', $sku, $unit)], 404);
        }
    }
}
