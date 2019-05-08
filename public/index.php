<?php
declare(strict_types=1);

use DemoApi\Controller\GetAllProducts;
use DemoApi\Controller\GetProductBySku;
use DemoApi\Controller\GetProductUnitPrice;
use DI\ContainerBuilder;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Narrowspark\HttpEmitter\SapiEmitter;
use Relay\Relay;
use Zend\Diactoros\ServerRequestFactory;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$environment = getenv('DEMO_API_ENV');
if (empty($environment)) {
    $environment = 'dev';
}

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions("di.config.$environment.php");

$container = $containerBuilder->build();
$routes = simpleDispatcher(function (RouteCollector $r) {
    $r->get('/api/v1/products', GetAllProducts::class);
    $r->get('/api/v1/products/[{sku}]', GetProductBySku::class);
    $r->get('/api/v1/products/{sku}/prices[/{unit}[/]]', GetProductUnitPrice::class);
});

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);

$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

$emitter = new SapiEmitter();
return $emitter->emit($response);
