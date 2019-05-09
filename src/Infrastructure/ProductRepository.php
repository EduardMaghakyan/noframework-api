<?php
declare(strict_types=1);

namespace DemoApi\Infrastructure;


use DemoApi\Domain\Price;
use DemoApi\Domain\Product;
use DemoApi\Domain\ProductRepositoryInterface;

/**
 * Class ProductRepository
 * @package DemoApi\Infrastructure
 */
class ProductRepository implements ProductRepositoryInterface
{
    public function findAllProducts(): array
    {
        $products = $this->getProductsFromSource();
        return array_values($products);
    }

    public function findProductBySku(string $sku): ?Product
    {
        $products = $this->getProductsFromSource();
        return isset($products[$sku]) ? $products[$sku] : null;
    }

    private function addPrices(Product $productEntity)
    {
        $prices = json_decode(file_get_contents(__DIR__ . '/db/prices.json'), true);
        $productPrices = [];
        foreach ($prices as $price) {
            if ($price['id'] === $productEntity->getSku()) {
                $productPrice = new Price();
                $productPrice->setCurrency($price['price']['currency']);
                $productPrice->setUnit($price['unit']);
                $productPrice->setValue($price['price']['value']);
                $productPrices[] = $productPrice;
            }
        }
        $productEntity->setPrices($productPrices);
    }

    /**
     * @return array
     */
    private function getProductsFromSource(): array
    {
        $products = [];
        $productXml = simplexml_load_file(__DIR__ . '/db/products.xml');
        foreach ($productXml->children() as $product) {
            $productEntity = new Product();
            $productEntity->setId($product['id']->__toString());
            $productEntity->setName($product->Name->__toString());
            $productEntity->setDescription(trim(str_replace(["\n", "\r"], "", $product->Description->__toString())));
            $productEntity->setSku($product->sku->__toString());
            $this->addPrices($productEntity);
            $products[$product->sku->__toString()] = $productEntity;
        }
        return $products;
    }
}
