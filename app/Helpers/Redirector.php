<?php

declare(strict_types=1);

namespace App\Helpers;

use Psr\Http\Message\ResponseInterface;
use Slim\Interfaces\RouteParserInterface;
use Slim\Psr7\Response;

class Redirector
{
    protected $response;

    public function __construct(?string $url)
    {
        $this->response = new Response();

        if ($url) {
            $this->response = $this->response->withHeader('Location', $url);

            return $this->send();
        }

        return $this;
    }

    public function route(?string $name)
    {
        $this->response = $this->response->withHeader('Location', url_for($name));

        return $this->send();
    }

    public function send()
    {
        return $this->response->withStatus(302);
    }
}