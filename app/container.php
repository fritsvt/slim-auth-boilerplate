<?php

use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Interop\Container\ContainerInterface;
use function DI\get;

use App\Validation\Contracts\ValidatorInterface;
use App\Validation\Validator;
use Slim\Flash\Messages;
use App\Auth\Auth;
use Slim\Csrf\Guard;

return [
    'router' => get(Slim\Router::class),
    ValidatorInterface::class => function(ContainerInterface $c) {
        return new Validator;
    },
    Auth::class => function(ContainerInterface $c){
        return new Auth;
    },
    Guard::class => function (ContainerInterface $c) {
        return new Guard();
    },
    Messages::class => function(ContainerInterface $c) {
        return new Messages();
    },
    Twig::class => function (ContainerInterface $c) {
        $twig = new Twig(__DIR__.'/../resources/views', [
            'cache' => (new App\Helpers\Config())->get('production') === true ? __DIR__ . '/../resources/views/cache' : false,
            'debug' => (new App\Helpers\Config())->get('production') !== true
        ]);

        $twig->addExtension(new TwigExtension(
            $c->get('router'),
            $c->get('request')->getUri()
        ));

        $twig->getEnvironment()->addGlobal('auth', [
            'check' => $c->get(Auth::class)->check(),
            'user' => $c->get(Auth::class)->user(),
        ]);

        $twig->getEnvironment()->addGlobal('flash', $c->get(Messages::class));

        $twig->addExtension(new \App\Views\DebugExtension);
        $twig->addExtension(new \App\Views\ConfigExtension);

        return $twig;
    }
];