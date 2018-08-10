<?php
/**
 * Slim Framework (http://slimframework.com)
 *
 * @link      https://github.com/slimphp/Twig-View
 * @copyright Copyright (c) 2011-2015 Josh Lockhart
 * @license   https://github.com/slimphp/Twig-View/blob/master/LICENSE.md (MIT License)
 */
namespace App\Views;

use App\Helpers\Config;

class ConfigExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('config', [$this, 'config'])
        ];
    }

    public function config($var, $default = null)
    {
        return config($var, $default);
    }
}