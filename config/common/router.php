<?php

declare(strict_types=1);

use App\Factory\AppRouterFactory;
use Yiisoft\Router\Group;
use Yiisoft\Router\RouteCollection;
use Yiisoft\Router\RouteCollectorInterface;
use Yiisoft\Router\RouteCollectionInterface;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Router\UrlMatcherInterface;
use Yiisoft\Router\FastRoute\UrlGenerator;

return [
    RouteCollectionInterface::class => RouteCollection::class,
];
