<?php

namespace App\Parameter;

use Yiisoft\RequestModel\RequestModel;
use Yiisoft\RequestModel\ValidatableModelInterface;
use Yiisoft\Validator\Rule\InRange;

class CollectionParameter extends RequestModel implements ValidatableModelInterface
{

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return (int) $this->getAttributeValue('query.currentPage', 1);
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return (int) $this->getAttributeValue('query.pageSize', 20);
    }

    /**
     * @param string $default
     * @return int|null
     */
    public function getOrder(string $default = "desc"): int
    {
        return (strtolower($this->getAttributeValue('query.order', $default))) == 'asc' ? SORT_ASC : SORT_DESC;
    }

    /**
     * @return string|null
     */
    public function getSort(): ?string
    {

        return $this->getAttributeValue('query.sort');
    }

    /**
     * @return string|null
     */
    public function getKeyword(): ?string
    {
        return $this->getAttributeValue('query.keyword');
    }

    /**
     * @return array
     */
    public function getRules(): array
    {
        return [
            'query.order' => [
                (new InRange(['asc', 'desc']))->skipOnEmpty(true)
            ]
        ];
    }
}
