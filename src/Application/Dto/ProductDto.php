<?php
declare(strict_types=1);

namespace DemoApi\Application\Dto;


class ProductDto
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

    public function __construct(string $sku, string $name, string $description)
    {
        $this->setSku($sku);
        $this->setName($name);
        $this->setDescription($description);
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
        ];
    }
}
