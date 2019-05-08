<?php
declare(strict_types=1);

use DemoApi\Application\Exceptions\ProductNotFoundException;
use DemoApi\Application\ProductService;
use DemoApi\Controller\GetAllProducts;
use DemoApi\Controller\GetProductBySku;
use DemoApi\Infrastructure\ProductRepository;
use function DI\create;
use function DI\get;

return [
    ProductNotFoundException::class => create(ProductNotFoundException::class),
    ProductRepository::class => create(ProductRepository::class),
    ProductService::class => create(ProductService::class)->constructor(get(ProductRepository::class)),
    GetAllProducts::class => create(GetAllProducts::class)->constructor(get(ProductService::class)),
    GetProductBySku::class => create(GetProductBySku::class)->constructor(get(ProductService::class)),
];
