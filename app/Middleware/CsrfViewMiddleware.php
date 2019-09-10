<?php

namespace App\Middleware;
use App\Helpers\CsrfGuard;
use Slim\Views\Twig;

class CsrfViewMiddleware  {

    protected $view;

    public function __construct(Twig $view, CsrfGuard $csrf)
    {
        $this->view = $view;
        $this->csrf = $csrf;
    }

    public function __invoke($request, $handler) {
        $this->view->getEnvironment()->addGlobal('csrf', [
            'field' => '
                <input type="hidden" name="' . $this->csrf->getTokenNameKey() . '" value="' . $this->csrf->getTokenName() . '">
                <input type="hidden" name="' . $this->csrf->getTokenValueKey() . '" value="' . $this->csrf->getTokenValue() . '">
            ',
        ]);

        return $handler->handle($request);
    }
}
