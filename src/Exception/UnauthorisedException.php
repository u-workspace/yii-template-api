<?php

declare(strict_types=1);

namespace App\Exception;

use Throwable;
use Exception;
use Yiisoft\Http\Status;

final class UnauthorisedException extends MainException
{
    public function __construct($message = 'Unauthorised request', $code = Status::UNAUTHORIZED, array $errors = [], Throwable $previous = null)
    {
        parent::__construct($message, $code, $errors, $previous);
    }
}
