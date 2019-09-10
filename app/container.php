<?php

use App\Validation\Rules\ReCaptcha;
use App\Validation\ValidatorFactory;
use Slim\Views\Twig;
use Psr\Container\ContainerInterface;

use Slim\Flash\Messages;
use App\Auth\Auth;

return [
    ValidatorFactory::class => function(ContainerInterface $c) {
        $validator = new ValidatorFactory($c);
        $_SESSION['valid_captcha'] = false;
        $validator->extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
            $recaptcha = new \ReCaptcha\ReCaptcha(config('captcha.private'));
            if (!isset($_SESSION['valid_captcha']) || $_SESSION['valid_captcha'] == false) {
                $_SESSION['valid_captcha'] = $recaptcha->verify($value, 'slim3-auth-boilerplate.test')->isSuccess();
            } else {
                return $_SESSION['valid_captcha'];
            }
            return $_SESSION['valid_captcha'];
        });

        return $validator;
    },
    Auth::class => function(ContainerInterface $c){
        return new Auth;
    },
    Messages::class => function(ContainerInterface $c) {
        return new Messages();
    },
    Twig::class => function (ContainerInterface $c) {
        $twig = new Twig(__DIR__.'/../resources/views', [
            'cache' => (new App\Helpers\Config())->get('production') === true ? __DIR__ . '/../resources/cache/views' : false,
            'debug' => (new App\Helpers\Config())->get('production') !== true
        ]);

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