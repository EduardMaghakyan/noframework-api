<?php
declare(strict_types=1);

use DemoApi\Application\Exceptions\ProductNotFoundException;
use DemoApi\Application\ProductService;
use DemoApi\Controller\GetAllProducts;
use DemoApi\Controller\GetProductBySku;
use function DI\create;
use function DI\get;
use Tests\Mocks\FakeProductRepository;

return [
    ProductNotFoundException::class => create(ProductNotFoundException::class),
    FakeProductRepository::class => create(FakeProductRepository::class),
    ProductService::class => create(ProductService::class)->constructor(get(FakeProductRepository::class)),
    GetAllProducts::class => create(GetAllProducts::class)->constructor(get(ProductService::class)),
    GetProductBySku::class => create(GetProductBySku::class)->constructor(get(ProductService::class)),
];
