<?php

return [
    'paths' => [
        'migrations' => 'migrations',
    ],
    'environments' => [
        'default_migration_table' => 'phinx_log',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => getenv('DB_HOST'),
            'name' => getenv('DB_NAME'),
            'user' => getenv('DB_USER'),
            'pass' => getenv('DB_PASS'),
            'charset' => 'utf8mb4'
        ],
    ],
];
