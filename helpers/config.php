<?php

function config($key, $default = null) {
    return (new \App\Helpers\Config())->get($key, $default);
}

function auth() {
    return new \App\Auth\Auth();
}