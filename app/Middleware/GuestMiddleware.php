<?php
namespace App\Middleware;
use App\Middleware\Middleware;
use App\Auth\Auth;
use Slim\Flash\Messages;
use Slim\Router;
class GuestMiddleware extends Middleware {
    public function __invoke($request, $response, $next)
    {
        $container = $this->container;
        if ($container->get(Auth::class)->check()) {
            $container->get(Messages::class)->addMessage('home-info', 'Je bent al ingelogd');
            return $response->withRedirect($container->get(Router::class)->pathFor('home'));
        }
        $response = $next($request, $response);
        return $response;
    }
}
