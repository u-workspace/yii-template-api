<?php
declare(strict_types=1);

namespace App\Exception;

use Throwable;
use Exception;
use Yiisoft\Http\Status;

final class ForbiddenException extends MainException
{
    public function __construct($message = 'Forbidden', $code = Status::FORBIDDEN, array $errors = [], Throwable $previous = null)
    {
        parent::__construct($message, $code, $errors, $previous);
    }
}
