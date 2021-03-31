<?php

declare(strict_types=1);

use Yiisoft\ErrorHandler\ErrorHandler;
use App\Helper\Sentry\SentryHelper;

/**
 * @var array $params
 */

return [
    ErrorHandler::class => [
        '__class' => ErrorHandler::class,
        'debug()' => [$params['yiisoft/error-handler']['verbose']]
    ],
    SentryHelper::class => [
        '__class' => SentryHelper::class,
        '__construct()' => [
            $params['sentry/dsn']
        ]
    ],
];
