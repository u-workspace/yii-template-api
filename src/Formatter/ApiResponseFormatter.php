<?php

declare(strict_types=1);

namespace App\Formatter;

use App\Factory\ApiResponseDataFactory;
use App\Helper\Request\Request;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\ActiveRecord\ActiveRecord;
use Yiisoft\Arrays\ArrayableTrait;
use Yiisoft\Arrays\ArrayHelper;
use App\Data\OffsetPaginator;
use Yiisoft\Data\Paginator\PaginatorException;
use Yiisoft\DataResponse\DataResponse;
use Yiisoft\DataResponse\DataResponseFormatterInterface;
use Yiisoft\DataResponse\Formatter\JsonDataResponseFormatter;

final class ApiResponseFormatter implements DataResponseFormatterInterface
{
    private ApiResponseDataFactory $apiResponseDataFactory;
    private JsonDataResponseFormatter $jsonDataResponseFormatter;
    private Request $request;

    /**
     * ApiResponseFormatter constructor.
     * @param ApiResponseDataFactory $apiResponseDataFactory
     * @param JsonDataResponseFormatter $jsonDataResponseFormatter
     * @param Request $request
     */
    public function __construct(ApiResponseDataFactory $apiResponseDataFactory, JsonDataResponseFormatter $jsonDataResponseFormatter, Request $request)
    {
        $this->apiResponseDataFactory = $apiResponseDataFactory;
        $this->jsonDataResponseFormatter = $jsonDataResponseFormatter;
        $this->request = $request;
    }

    /**
     * @param DataResponse $dataResponse
     * @return ResponseInterface
     */
    public function format(DataResponse $dataResponse): ResponseInterface
    {
        $data = $dataResponse->getData();

        if ($data instanceof OffsetPaginator) {
            $items = [];
            try {
                foreach ($data->read() as $item) {
                    /* @var $item ArrayableTrait */
                    $items[] = is_array($item) ? $item : $item->toArray(expand: $this->request->getExpand());
                }
            } catch (PaginatorException $paginatorException) {
                // catch the exception and make sure it is handle it with empty list.
                // since we allow currentPage value greater than it's maximum page.
                $items = [];
            }

            $response = $dataResponse->withData(ArrayHelper::merge(
                $this->apiResponseDataFactory->createFromResponse($dataResponse->withData([
                    'list' => $items,
                    'pagination' => [
                        "currentPage" => $data->getCurrentPage(),
                        "pageSize" => $data->getPageSize(),
                        "pageCount" => $data->getTotalPages(),
                        "isMore" => ($data->getCurrentPage() < $data->getTotalPages()),
                        "itemCount" => $data->getTotalItems()
                    ]
                ]))->toArray(),
            ));
        } else if ($data instanceof ActiveRecord) {
            $dataResponse = $dataResponse->withData($dataResponse->getData()->toArray(expand: $this->request->getExpand()));
            $response = $dataResponse->withData(
                $this->apiResponseDataFactory->createFromResponse($dataResponse)->toArray()
            );
        } else {
            $response = $dataResponse->withData(
                $this->apiResponseDataFactory->createFromResponse($dataResponse)->toArray()
            );
        }

        return $this->jsonDataResponseFormatter->format($response);
    }
}
