<?php
namespace App\Middleware;
use App\Middleware\Middleware;
use App\Auth\Auth;
use Slim\Flash\Messages;
use Slim\Router;

class AuthMiddleware extends Middleware {
    public function __invoke($request, $response, $next)
    {
        $container = $this->container;
        if (!$container->get(Auth::class)->check()) {
            $container->get(Messages::class)->addMessage('warning', 'Log in om verder te gaan');
            return $response->withRedirect($container->get(Router::class)->pathFor('login'));
        }
        $response = $next($request, $response);
        return $response;
    }
}
