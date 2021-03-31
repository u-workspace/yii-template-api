<?php

declare(strict_types=1);

namespace App\Exception;

use Throwable;
use Exception;
use Yiisoft\Http\Status;

final class NotFoundException extends MainException
{
    public function __construct($message = 'Entity not found', $code = Status::NOT_FOUND, array $errors = [], Throwable $previous = null)
    {
        parent::__construct($message, $code, $errors, $previous);
    }
}
