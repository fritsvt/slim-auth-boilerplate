<?php

require __DIR__ . '/bootstrap/app.php';

$DatabaseConfig = config('database');

return [
    'paths' => [
        'migrations' => 'database/migrations',
        'seeds' => 'database/seeds'
    ],
    'migration_base_class' => 'App\Database\Migrations\Migration',
    'templates' => [
        'file' => 'app/Database/Migrations/MigrationStub.php'
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default' => [
            'adapter' => $DatabaseConfig['driver'],
            'host' => $DatabaseConfig['host'],
            'port' => $DatabaseConfig['port'],
            'name' => $DatabaseConfig['database'],
            'user' => $DatabaseConfig['username'],
            'pass' => $DatabaseConfig['password']
        ]
    ]
];
