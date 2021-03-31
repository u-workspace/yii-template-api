<?php

namespace App\Exception;

interface ApplicationException extends \Throwable
{
    public function getErrors(): array;
}
