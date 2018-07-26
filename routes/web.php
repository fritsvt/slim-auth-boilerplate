<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\ApiMiddleware;
use Slim\Views\Twig;
use App\Middleware\CsrfViewMiddleware;
use Slim\Csrf\Guard;

$container = $app->getContainer();

// CSRF protected routes
$app->group('', function() {
    $this->get('/', ['App\Controllers\HomeController', 'index'])->setName('home');
})->add(new CsrfViewMiddleware($container->get(Twig::class), $container->get(Guard::class) ))->add($container->get(Guard::class));

// Guest Routes
$app->group('', function() {
    $this->get('/register', ['App\Controllers\Auth\AuthController', 'getRegister'])->setName('register');
    $this->post('/register', ['App\Controllers\Auth\AuthController', 'postRegister'])->setName('register');

    $this->get('/login', ['App\Controllers\Auth\AuthController', 'getLogin'])->setName('login');
    $this->post('/login', ['App\Controllers\Auth\AuthController', 'postLogin'])->setName('login');
})->add(new GuestMiddleware($container))->add(new CsrfViewMiddleware($container->get(Twig::class), $container->get(Guard::class) ))->add($container->get(Guard::class));

// Authenticated Routes
$app->group('', function() {
    $this->post('/logout', ['App\Controllers\Auth\AuthController', 'logout'])->setName('logout');
})->add(new AuthMiddleware($container))->add(new CsrfViewMiddleware($container->get(Twig::class), $container->get(Guard::class) ))->add($container->get(Guard::class));
