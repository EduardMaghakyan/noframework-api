<?php
declare(strict_types=1);

use DemoApi\Application\ProductService;
use DemoApi\Controller\GetAllProducts;
use DemoApi\Infrastructure\ProductRepository;
use DI\ContainerBuilder;
use function DI\create;
use function DI\get;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Narrowspark\HttpEmitter\SapiEmitter;
use Relay\Relay;
use Zend\Diactoros\ServerRequestFactory;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    ProductRepository::class => create(ProductRepository::class),
    ProductService::class => create(ProductService::class)->constructor(get(ProductRepository::class)),
    GetAllProducts::class => create(GetAllProducts::class)->constructor(get(ProductService::class)),
]);

$container = $containerBuilder->build();
$routes = simpleDispatcher(function (RouteCollector $r) {
    $r->get('/api/v1/products', GetAllProducts::class);
});

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);

$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

$emitter = new SapiEmitter();
return $emitter->emit($response);
