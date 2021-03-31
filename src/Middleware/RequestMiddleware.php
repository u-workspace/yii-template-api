<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Helper\Request\Access;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Yiisoft\ActiveRecord\ActiveRecordFactory;
use Yiisoft\DataResponse\DataResponseFactoryInterface;
use Yiisoft\Factory\Exceptions\InvalidConfigException;

final class RequestMiddleware implements MiddlewareInterface
{

    /**
     * RequestMiddleware constructor.
     * @param DataResponseFactoryInterface $dataResponseFactory
     * @param Access $access
     * @param ActiveRecordFactory $activeRecordFactory
     */
    public function __construct(
        private DataResponseFactoryInterface $dataResponseFactory,
        private Access $access,
        private ActiveRecordFactory $activeRecordFactory,
    )
    {
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws InvalidConfigException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $headerRole = $request->getHeader('DOO-Role');
        $headerAuth = $request->getHeader('Authorization');

        $role = null;
        $token = null;

        if (isset($headerRole[0])) {
            $role = $headerRole[0];
        }

        if (isset($headerAuth[0])) {
            $token = str_replace("Bearer ", "", $headerAuth[0]);
        }

        $this->access->setAccess($token, $role, $this->activeRecordFactory);

        return $handler->handle($request);
    }
}
