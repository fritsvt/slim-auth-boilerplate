<?php
namespace App\Middleware;
use App\Middleware\Middleware;
use App\Auth\Auth;
use Slim\Flash\Messages;
use Slim\Router;
class GuestMiddleware extends Middleware {

    public function __invoke($request, $handler)
    {
        $container = $this->container;

        if ($container->get(Auth::class)->check()) {
            $container->get(Messages::class)->addMessage('info', 'Je bent al ingelogd');
            return redirect()->route('home');
        }

        return $handler->handle($request);
    }

}
