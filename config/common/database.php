<?php

declare(strict_types=1);

use Yiisoft\Db\Mysql\Connection as MysqlConnection;
use Yiisoft\ActiveRecord\ActiveRecordFactory;

/**
 * @var array $params
 */

return [
    \Yiisoft\Db\Connection\ConnectionInterface::class => [
        '__class' => MysqlConnection::class,
        '__construct()' => [
            'dsn' => $params['yiisoft/db-mysql']['dsn']
        ],
        'setUsername()' => [$params['yiisoft/db-mysql']['username']],
        'setPassword()' => [$params['yiisoft/db-mysql']['password']]
    ],
    ActiveRecordFactory::class => [
        '__class' => ActiveRecordFactory::class,
    ],
    \Yiisoft\Db\Transaction\Transaction::class => [
        '__class' => \Yiisoft\Db\Transaction\Transaction::class,
        '__construct()' => [
            \Yiisoft\Factory\Definitions\Reference::to(\Yiisoft\Db\Connection\ConnectionInterface::class),
            \Yiisoft\Factory\Definitions\Reference::to(\Psr\Log\LoggerInterface::class)
        ]
    ],
];
