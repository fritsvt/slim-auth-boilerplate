<?php

use App\Helpers\Redirector;

function config($key, $default = null) {
    return (new \App\Helpers\Config())->get($key, $default);
}

function auth() {
    return new \App\Auth\Auth();
}

function url_for($name, $data = [], $queryParams = []) {
    global $app;

    return $app->getRouteCollector()->getRouteParser()->urlFor($name, $data, $queryParams);
}

function redirect($url = null) {
    return new Redirector($url);
}

function input($key, $default = null) {
    if (isset($_POST[$key]) && !empty($_POST[$key])) {
        return (string) $_POST[$key];
    }

    return $default;
}