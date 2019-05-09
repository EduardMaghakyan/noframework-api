<?php
declare(strict_types=1);

namespace Tests\Mocks;

use DemoApi\Application\Dto\ProductWithPriceDto;
use DemoApi\Domain\ProductRepositoryInterface;
use DemoApi\Infrastructure\ProductRepository;

class FakeProductRepository extends ProductRepository implements ProductRepositoryInterface
{
    public function fakeProductWithPricesDto(string $sku): ProductWithPriceDto
    {
        $selectedProduct = $this->findProductBySku($sku);
        return new ProductWithPriceDto($selectedProduct->getSku(), $selectedProduct->getName(),
            $selectedProduct->getDescription(), $selectedProduct->getPrices());
    }
}
