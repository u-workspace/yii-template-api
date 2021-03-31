<?php
declare(strict_types=1);

namespace App\Exception;

use Throwable;

class MainException extends \Exception implements ApplicationException
{
    protected array $errors = [];

    /**
     * MainException constructor.
     *
     * @param string $message
     * @param int $code
     * @param array $errors
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 500, array $errors = [], Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }

    /**
     * For getting errors
     *
     * @return array
     */
    public function getErrors(): array
    {
        $errors = $this->errors;

        if(isset($errors[0])) {
            if(is_string($errors[0])) {
                $errors = [
                    'errors' => $errors
                ];
            }
        }

        return $errors;
    }
}
