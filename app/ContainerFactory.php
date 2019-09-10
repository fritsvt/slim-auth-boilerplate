<?php

namespace App;

use App\Helpers\Config;
use DI\ContainerBuilder;
use Exception;
use Psr\Container\ContainerInterface;
class ContainerFactory
{
    /**
     * @param string $rootPath
     *
     * @return ContainerInterface
     * @throws Exception
     */
    public static function create()
    {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addDefinitions(__DIR__ . '/container.php');

        // Note: In production, you should enable container-compilation.
        if ((new Config())->get('production')) {
            $containerBuilder->enableCompilation(__DIR__ . '/../resources/cache/container');
        }

        return $containerBuilder->build();
    }
}