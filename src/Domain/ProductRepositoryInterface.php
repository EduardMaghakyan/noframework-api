<?php
declare(strict_types=1);


namespace DemoApi\Domain;


interface ProductRepositoryInterface
{
    public function findAllProducts(): array;
}
