<?php
declare(strict_types=1);

use DemoApi\HelloWorld;
use DI\ContainerBuilder;
use function DI\create;
use function DI\get;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Narrowspark\HttpEmitter\SapiEmitter;
use Relay\Relay;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    HelloWorld::class => create(HelloWorld::class)->constructor(get('Response')),
    'Response' => function () {
        return new Response();
    },
]);

$container = $containerBuilder->build();
$helloWorld = $container->get(HelloWorld::class);
$routes = simpleDispatcher(function (RouteCollector $r) use ($helloWorld) {
    $r->get('/hello/{name}', [$helloWorld, 'index']);
});

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);

$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

$emitter = new SapiEmitter();
return $emitter->emit($response);
