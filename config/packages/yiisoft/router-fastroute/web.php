<?php

declare(strict_types=1);

use Yiisoft\Injector\Injector;
use Yiisoft\Router\FastRoute\UrlMatcher;
use Yiisoft\Router\UrlMatcherInterface;

/** @var array $params */

return [
    UrlMatcherInterface::class => new \App\Factory\AppRouterFactory(),
];
