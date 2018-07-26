<?php
session_start();

use App\App;
use Slim\Views\Twig;
use Illuminate\Database\Capsule\Manager as Capsule;
use Respect\Validation\Validator as v;

require __DIR__.'/../vendor/autoload.php';

$app = new App;

$container = $app->getContainer();

require __DIR__ . '/config.php';

$capsule = new Capsule;
$capsule->addConnection(
    (new \App\Helpers\Config())->get('database')
);

$capsule->setAsGlobal();
$capsule->bootEloquent();


$app->add(new \App\Middleware\ValidationErrorsMiddleware($container->get(Twig::class)));
$app->add(new \App\Middleware\OldInputMiddleware($container->get(Twig::class)));

v::with('App\\Validation\\Rules\\');


// Inlude all route files from the routes directory
foreach (glob(__DIR__ . "/../routes/*.php") as $filename)
{
    include $filename;
}

// Include all helpers
// Inlude all route files from the routes directory
foreach (glob(__DIR__ . "/../helpers/*.php") as $filename)
{
    include $filename;
}