<?php
declare(strict_types=1);

namespace DemoApi\Application\Dto;


class UnitPriceDto
{
    /**
     * @var float
     */
    private $value;

    /**
     * @var string
     */
    private $currency;

    public function __construct(
        float $value,
        string $currency
    ) {
        $this->setValue($value);
        $this->setCurrency($currency);
    }

    public function toArray()
    {
        return [
            'value' => $this->getValue(),
            'currency' => $this->getCurrency(),
        ];
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue(float $value): void
    {
        $this->value = $value;
    }
}
