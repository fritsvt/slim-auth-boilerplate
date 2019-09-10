<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Helpers\CsrfGuard;
use Slim\Views\Twig;
use App\Middleware\CsrfViewMiddleware;
use Slim\Csrf\Guard;

// CSRF protected routes
$app->group('', function($app) {
    $app->get('/', ['App\Controllers\HomeController', 'index'])->setName('home');
})->add(new CsrfViewMiddleware($container->get(Twig::class), $container->get(CsrfGuard::class) ))->add($container->get(CsrfGuard::class));

// Guest Routes
$app->group('', function($app) {
    $app->get('/register', ['App\Controllers\Auth\AuthController', 'getRegister'])->setName('register');
    $app->post('/register', ['App\Controllers\Auth\AuthController', 'postRegister'])->setName('register');

    $app->get('/login', ['App\Controllers\Auth\AuthController', 'getLogin'])->setName('login');
    $app->post('/login', ['App\Controllers\Auth\AuthController', 'postLogin'])->setName('login');
})->add(new GuestMiddleware($container))->add(new CsrfViewMiddleware($container->get(Twig::class), $container->get(CsrfGuard::class) ))->add($container->get(CsrfGuard::class));

// Authenticated Routes
$app->group('', function($app) {
    $app->post('/logout', ['App\Controllers\Auth\AuthController', 'logout'])->setName('logout');
})->add(new AuthMiddleware($container))->add(new CsrfViewMiddleware($container->get(Twig::class), $container->get(CsrfGuard::class) ))->add($container->get(CsrfGuard::class));
