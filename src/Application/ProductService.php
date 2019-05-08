<?php
declare(strict_types=1);

namespace DemoApi\Application;


use DemoApi\Application\Dto\ProductDto;
use DemoApi\Application\Dto\ProductWithPriceDto;
use DemoApi\Application\Dto\UnitPriceDto;
use DemoApi\Application\Exceptions\ProductNotFoundException;
use DemoApi\Application\Exceptions\ProductUnitPriceNotFoundException;
use DemoApi\Domain\Product;
use DemoApi\Domain\ProductRepositoryInterface;

class ProductService
{
    /**
     * @var ProductRepositoryInterface
     */
    private $repository;

    public function __construct(ProductRepositoryInterface $productsRepo)
    {
        $this->repository = $productsRepo;
    }

    public function getAllProducts(): array
    {
        $products = $this->repository->findAllProducts();
        return array_map(function (Product $product) {
            return new ProductDto($product->getSku(), $product->getName(), $product->getDescription());
        }, $products);
    }

    public function getProductBySku(string $sku): ProductWithPriceDto
    {
        $product = $this->repository->findProductBySku($sku);
        if ($product === null) {
            throw new ProductNotFoundException();
        }
        $response = null;
        if ($product) {
            $response = new ProductWithPriceDto($product->getSku(), $product->getName(), $product->getDescription(),
                $product->getPrices());
        }

        return $response;
    }

    public function getProductUnitPrice(string $sku, string $unit): UnitPriceDto
    {
        $product = $this->repository->findProductBySku($sku);
        if ($product === null) {
            throw new ProductNotFoundException();
        }

        foreach ($product->getPrices() as $price) {
            if ($price->getUnit() === $unit) {
                return new UnitPriceDto($price->getValue(), $price->getCurrency());
            }
        }

        throw new ProductUnitPriceNotFoundException();
    }
}
