<?php
session_start();

use App\ContainerFactory;
use App\Helpers\Config;
use App\Helpers\CsrfGuard;
use App\Middleware\OldInputMiddleware;
use App\Middleware\ValidationErrorsMiddleware;
use DI\Bridge\Slim\Bridge;
use Slim\Views\Twig;
use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Views\TwigMiddleware;

require __DIR__.'/../vendor/autoload.php';

$production = (new Config())->get('production');

$capsule = new Capsule;
$capsule->addConnection(
    (new Config())->get('database')
);
$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    $container = ContainerFactory::create();
} catch (Exception $e) {
    die($e->getMessage());
}

$container->set('db', $capsule);

$app = Bridge::create($container);

$responseFactory = $app->getResponseFactory();
$container->set(CsrfGuard::class, function () use ($responseFactory) {
    return new CsrfGuard($responseFactory);
});

// Set the cache file for the routes. Note that you have to delete this file
// whenever you change the routes.
if ($production) {
    $app->getRouteCollector()->setCacheFile(
        __DIR__ .  '/../resources/cache/routes.cache'
    );
}

// Add the routing middleware.
$app->addRoutingMiddleware();
// Add body parsing middleware
$app->addBodyParsingMiddleware();
// Add the twig middleware (which when processed would set the 'view' to the container).
$app->add(
    new TwigMiddleware(
        $container->get(Twig::class),
        $app->getRouteCollector()->getRouteParser(),
        $app->getBasePath()
    )
);
// validation
$app->add(new ValidationErrorsMiddleware($container->get(Twig::class)));
$app->add(new OldInputMiddleware($container->get(Twig::class)));

// Add error handling middleware.
$displayErrorDetails = !$production;
$logErrors = $production;
$logErrorDetails = $production;
$app->addErrorMiddleware($displayErrorDetails, $logErrors, $logErrorDetails);

// Inlude all route files from the routes directory
foreach (glob(__DIR__ . "/../routes/*.php") as $filename)
{
    include $filename;
}

foreach (glob(__DIR__ . "/../helpers/*.php") as $filename)
{
    include $filename;
}