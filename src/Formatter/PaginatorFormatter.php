<?php

declare(strict_types=1);

namespace App\Formatter;

use App\Data\OffsetPaginator;

final class PaginatorFormatter
{
    public function format(OffsetPaginator $paginator): array
    {
        return [
            'pageSize' => $paginator->getPageSize(),
            'currentPage' => $paginator->getCurrentPage(),
            'totalPages' => $paginator->getTotalPages()
        ];
    }
}
