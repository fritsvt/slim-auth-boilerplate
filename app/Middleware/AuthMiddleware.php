<?php
namespace App\Middleware;
use App\Middleware\Middleware;
use App\Auth\Auth;
use Slim\Flash\Messages;
use Slim\Router;

class AuthMiddleware extends Middleware {
    public function __invoke($request, $handler)
    {
        $container = $this->container;

        if (!$container->get(Auth::class)->check()) {
            $container->get(Messages::class)->addMessage('warning', 'Log in om verder te gaan');
            return redirect()->route('login');
        }

        return $handler->handle($request);
    }
}
