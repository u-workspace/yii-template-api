<?php

declare(strict_types=1);

namespace App\Exception;

use Throwable;
use Exception;
use Yiisoft\Http\Status;

class BadRequestException extends MainException
{
    public function __construct($message = 'Bad request', $code = Status::BAD_REQUEST, array $errors = [], Throwable $previous = null)
    {
        parent::__construct($message, $code, $errors, $previous);
    }
}
