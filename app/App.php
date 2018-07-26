<?php

namespace App;

use DI\ContainerBuilder;
use DI\Bridge\Slim\App as DIBridge;
use App\Helpers\Config;

class App extends DIBridge
{
    protected function configureContainer(ContainerBuilder $builder)
    {
        $builder->addDefinitions([
            'settings.displayErrorDetails' => (new Config)->get('production') !== true,
        ]);

        $builder->addDefinitions(__DIR__.'/container.php');
    }
}