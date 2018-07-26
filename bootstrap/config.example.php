<?php

return [
    'production' => false,
    'database' => [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => 3306,
        'database' => 'homestead',
        'username' => 'root',
        'password' => 'secret',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ],
    'captcha' => [
        'public' => '',
        'private' => ''
    ]
];