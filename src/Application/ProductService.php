<?php
declare(strict_types=1);

namespace DemoApi\Application;


use DemoApi\Application\Dto\ProductDto;
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

    public function getAllProducts()
    {
        $products = $this->repository->findAllProducts();
        return array_map(function (Product $product) {
            return new ProductDto($product->getSku(), $product->getName(), $product->getDescription());
        }, $products);
    }
}
