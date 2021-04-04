<?php

declare(strict_types=1);

namespace App\Factory;

use App\Middleware\ExceptionMiddleware;
use App\Middleware\RequestMiddleware;
use Psr\Container\ContainerInterface;
use Yiisoft\Aliases\Aliases;
use Yiisoft\DataResponse\Middleware\FormatDataResponse;
use Yiisoft\Request\Body\RequestBodyParser;
use Yiisoft\Router\FastRoute\UrlMatcher;
use Yiisoft\Router\Group;
use Yiisoft\Router\RouteCollection;
use Yiisoft\Router\RouteCollectorInterface;

class AppRouterFactory
{
    /**
     * @param ContainerInterface $container
     * @return UrlMatcher
     */
    public function __invoke(ContainerInterface $container)
    {
        $collector = $container->get(RouteCollectorInterface::class);
        $aliases = $container->get(Aliases::class);

        $collector->addGroup(
            Group::create()
                ->middleware(RequestMiddleware::class)
                ->middleware(FormatDataResponse::class)
                ->middleware(RequestBodyParser::class)
                ->middleware(ExceptionMiddleware::class)
                ->routes(...$this->getRoutes($aliases))
        );

        return new UrlMatcher(new RouteCollection($collector));
    }

    /**
     * @param Aliases $aliases
     * @return array
     */
    private function getRoutes(Aliases $aliases): array
    {
        return [
            ...(require $aliases->get('@src/Factory/Route/status.php')),
        ];
    }
}
