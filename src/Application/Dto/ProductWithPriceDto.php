<?php
declare(strict_types=1);

namespace DemoApi\Application\Dto;


use DemoApi\Domain\Price;

class ProductWithPriceDto
{
    /**
     * @var string
     */
    private $sku;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var Price[]
     */
    private $prices;

    public function __construct(string $sku, string $name, string $description, array $prices)
    {
        $this->setSku($sku);
        $this->setName($name);
        $this->setDescription($description);
        $this->setPrices($prices);
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     */
    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    public function toArray()
    {
        return [
            'sku' => $this->getSku(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'prices' => array_map(function (Price $price) {
                return [
                    'value' => $price->getValue(),
                    'currency' => $price->getCurrency(),
                    'unit' => $price->getUnit(),
                ];
            }, $this->getPrices()),
        ];
    }

    /**
     * @return Price[]
     */
    public function getPrices(): array
    {
        return $this->prices;
    }

    /**
     * @param Price[] $prices
     */
    public function setPrices(array $prices): void
    {
        $this->prices = $prices;
    }
}
