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

class DebugExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('dump', [$this, 'dump'])
        ];
    }

    public function dump($var)
    {
        if ((new Config())->get('production') === true) {
            return;
        }
    	dump($var);
    }
}