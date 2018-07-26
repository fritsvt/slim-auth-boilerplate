<?php

namespace App\Middleware;
use Slim\Csrf\Guard;
use Slim\Views\Twig;

class CsrfViewMiddleware  {
    protected $view;
    public function __construct(Twig $view, Guard $csrf)
    {
        $this->view = $view;
        $this->csrf = $csrf;
    }
    public function __invoke($request, $response, $next) {
        $this->view->getEnvironment()->addGlobal('csrf', [
            'field' => '
                <input type="hidden" name="' . $this->csrf->getTokenNameKey() . '" value="' . $this->csrf->getTokenName() . '">
                <input type="hidden" name="' . $this->csrf->getTokenValueKey() . '" value="' . $this->csrf->getTokenValue() . '">
            ',
        ]);
        $response = $next($request, $response);
        return $response;
    }
}
