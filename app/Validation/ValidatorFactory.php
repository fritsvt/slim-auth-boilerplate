<?php

namespace App\Validation;

use Illuminate\Validation;
use Illuminate\Translation;
use Illuminate\Filesystem\Filesystem;

class ValidatorFactory
{
    private $factory;

    public function __construct($container = null)
    {
        $this->factory = new Validation\Factory(
            $this->loadTranslator()
        );

        if ($container) {
            $this->factory->setPresenceVerifier(new Validation\DatabasePresenceVerifier(
                $container->get('db')->getDatabaseManager())
            );
        }
    }

    public function make(...$args)
    {
        $validation = call_user_func_array(
            [$this->factory, 'make'],
            $args
        );

        if ($validation->fails()) {
            $_SESSION['errors'] = $validation->errors()->getMessages();
        }

        return $validation;
    }

    protected function loadTranslator()
    {
        $dir = str_replace(
                '\app', '', dirname(dirname(__FILE__))
            ) . '/resources/lang';
        $filesystem = new Filesystem();
        $loader = new Translation\FileLoader(
            $filesystem, $dir
        );
        $loader->addNamespace(
            'lang',
            $dir
        );
        $loader->load('en', 'validation', 'lang');

        return new Translation\Translator($loader, 'en');
    }

    public function __call($method, $args)
    {
        if ($method == 'make') {
            return $this->make($args);
        }

        return call_user_func_array(
            [$this->factory, $method],
            $args
        );
    }
}