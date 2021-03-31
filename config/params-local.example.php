<?php

use Yiisoft\Db\Connection\Dsn;

return [
    'yiisoft/db-mysql' => [
        'dsn' => (new Dsn('mysql', '127.0.0.1', 'database_name', '3306', ['charset' => 'utf8']))->asString(),
        'username' => 'root',
        'password' => '',
    ],
    "sentry/dsn" => '',
];
