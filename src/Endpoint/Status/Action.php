<?php
declare(strict_types=1);

namespace App\Endpoint\Status;

use Yiisoft\DataResponse\DataResponse;
use Yiisoft\DataResponse\DataResponseFactoryInterface;

class Action
{
    /**
     * @param DataResponseFactoryInterface $dataResponseFactory
     * @return DataResponse
     */
    public function run(
        DataResponseFactoryInterface $dataResponseFactory
    )
    {
        return $dataResponseFactory->createResponse([
            'status' => true,
            'message' => 'health'
        ]);
    }
}
