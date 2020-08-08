<?php

return [
    'default' => 'pgsql',
    'sqlite_testing' => [
        'driver'   => 'sqlite',
        'database' => ':memory:',
        'prefix'   => '',
    ],
    'connections' => [
        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
        'sqlite' => [
            'database' =>  env('DB_DATABASE', database_path('tests.sqlite')),
            'driver' => 'sqlite',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
    ],
    'migrations' => 'migrations'
];
