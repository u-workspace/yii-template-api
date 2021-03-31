<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\ApiResponseData;
use App\Helper\Request\Access;
use Yiisoft\DataResponse\DataResponse;
use Yiisoft\Http\Status;

final class ApiResponseDataFactory
{
    /**
     * ApiResponseDataFactory constructor.
     * @param Access $access
     */
    public function __construct(private Access $access)
    {
    }

    public function createFromResponse(DataResponse $response): ApiResponseData
    {
        if ($response->getStatusCode() !== Status::OK) {
            return $this->createErrorResponse()
                ->setErrorCode($response->getStatusCode())
                ->setErrorMessage($this->getErrorMessage($response))
                ->setErrors($this->getErrors($response));
        }

        return $this->createSuccessResponse()
            ->setData($response->getData());
    }

    public function createSuccessResponse(): ApiResponseData
    {
        return $this->createResponse()->setStatus('success');
    }

    public function createErrorResponse(): ApiResponseData
    {
        return $this->createResponse()->setStatus('failed');
    }

    public function createResponse(): ApiResponseData
    {
        return new ApiResponseData($this->access->getRequestAs());
    }

    private function getErrorMessage(DataResponse $response): string
    {
        $data = $response->getReasonPhrase();
        if (is_string($data) && !empty($data)) {
            return $data;
        }

        return 'Unknown error';
    }

    private function getErrors(DataResponse $response): ?array
    {
        $errors = $response->getData();

        if(is_array($errors) && !empty($errors)) {
            return $errors;
        }

        return null;
    }
}
