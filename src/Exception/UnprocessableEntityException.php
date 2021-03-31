<?php
declare(strict_types=1);

namespace App\Exception;

use Throwable;
use Exception;
use Yiisoft\Http\Status;

final class UnprocessableEntityException extends MainException
{
    public function __construct($message = 'Unprocessable Entity', $code = Status::UNPROCESSABLE_ENTITY, array $errors = [], Throwable $previous = null)
    {
        parent::__construct($message, $code, $errors, $previous);
    }
}
