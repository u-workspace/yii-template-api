<?php

declare(strict_types=1);

namespace App\Dto;

final class ApiResponseData
{
    private string $status = '';

    private string $errorMessage = '';

    private ?array $errors = null;

    private ?int $errorCode = null;

    private ?array $data = null;

    public function __construct(private string $accessAs = "Member")
    {
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(string $errorMessage): self
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    public function getErrors(): ?array
    {
        return $this->errors;
    }

    public function setErrors(?array $errors): self
    {
        $this->errors = $errors;
        return $this;
    }

    public function getErrorCode(): ?int
    {
        return $this->errorCode;
    }

    public function setErrorCode(int $errorCode): self
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    public function getData(): ?array
    {
        if($this->reformatErrors()) {
            return $this->reformatErrors();
        }

        return $this->data;
    }

    public function setData(?array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'requestAs' => $this->accessAs,
            'name' => $this->getStatus(),
            'message' => $this->getErrorMessage() == null ? "Success" : $this->getErrorMessage(),
            'code' => $this->getErrorCode() ?? 200,
            'data' => $this->getData(),
        ];
    }

    private function reformatErrors(): ?array
    {
        if(is_array($this->getErrors())) {
            $errors = [];

            foreach ($this->getErrors() as $key => $value) {
                $errors[$this->replaceErrorKey($key)] = $value;
            }

            return ['errors' => $errors];
        }

        return null;
    }

    private function replaceErrorKey(string $key): string
    {
        $availableReplace = [
            'body',
            'query',
            'attributes'
        ];

        $value = $key;

        foreach ($availableReplace as $replacer) {
            $value = str_replace(sprintf("%s.", $replacer), "", $value);
        }

        return $value;
    }
}
