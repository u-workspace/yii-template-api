<?php
declare(strict_types=1);

namespace App\Data;

use Closure;
use InvalidArgumentException;
use Yiisoft\ActiveRecord\ActiveQueryInterface;
use Yiisoft\ActiveRecord\ActiveRecordInterface;
use Yiisoft\Data\Reader\DataReaderInterface;
use Yiisoft\Data\Reader\Filter\FilterInterface;
use Yiisoft\Data\Reader\Filter\FilterProcessorInterface;
use Yiisoft\Data\Reader\FilterableDataInterface;
use Yiisoft\Data\Reader\OffsetableDataInterface;
use Yiisoft\Data\Reader\ReadableDataInterface;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Data\Reader\SortableDataInterface;

class Provider implements DataReaderInterface
{

    /**
     * @var ActiveQueryInterface
     */
    private ActiveQueryInterface $query;

    /**
     * @var int|null
     */
    private ?int $limit = null;

    /**
     * @var int|null
     */
    private ?int $offset = null;

    /**
     * @var Sort|null
     */
    private ?Sort $sorting = null;

    /**
     * @var FilterInterface|null
     */
    private ?FilterInterface $filterInterface = null;

    /**
     * @var Closure|null
     */
    private ?Closure $builder = null;

    /**
     * SelectDataReader constructor.
     * @param ActiveQueryInterface $query
     */
    public function __construct(ActiveQueryInterface $query)
    {
        $this->query = $query;
    }

    public function getIterator()
    {
        // TODO: Implement getIterator() method.
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return intval($this->buildQuery()->count());
    }

    /**
     * @param FilterInterface $filter
     * @return FilterableDataInterface
     */
    public function withFilter(FilterInterface $filter): FilterableDataInterface
    {
        $this->filterInterface = $filter;
    }

    public function withFilterProcessors(FilterProcessorInterface ...$filterProcessors): FilterableDataInterface
    {
        // TODO: Implement withFilterProcessors() method.
    }

    /**
     * @param int $offset
     * @return OffsetableDataInterface
     */
    public function withOffset(int $offset): OffsetableDataInterface
    {
        if($offset < 0) {
            throw new InvalidArgumentException('offset must not be less than 0');
        }

        $new = clone $this;

        if($new->offset != $offset) {
            $new->offset = $offset;
        }

        return $new;
    }

    /**
     * @param int $limit
     * @return ReadableDataInterface
     */
    public function withLimit(int $limit): ReadableDataInterface
    {
        if($limit < 0) {
            throw new InvalidArgumentException('limit must not be less than 0');
        }

        $new = clone $this;

        if($new->limit != $limit) {
            $new->limit = $limit;
        }

        return $new;
    }

    /**
     * @param callable $builder
     * @return $this
     */
    public function withBuilder(callable $builder): self
    {
        $new = clone $this;

        $new->builder = $builder;

        return $new;
    }

    /**
     * @param Sort|null $sorting
     * @return SortableDataInterface
     */
    public function withSort(?Sort $sorting): SortableDataInterface
    {
        $new = clone $this;

        if($new->sorting !== $sorting) {
            $new->sorting = $sorting;
        }

        return $new;
    }

    /**
     * @param int|null $limit
     */
    public function setLimit(int $limit): void
    {
        if($limit < 0) {
            throw new InvalidArgumentException('limit must not be less than 0');
        }

        $this->limit = $limit;
    }

    /**
     * @param int|null $offset
     */
    public function setOffset(?int $offset): void
    {
        if($offset < 0) {
            throw new InvalidArgumentException('limit must not be less than 0');
        }

        $this->offset = $offset;
    }

    /**
     * @param callable $builder
     */
    public function setBuilder(callable $builder): void
    {
        $this->builder = $builder;
    }

    /**
     * @param Sort|null $sorting
     * @return SortableDataInterface
     */
    public function setSort(?Sort $sorting): void
    {
        $this->sorting = $sorting;
    }

    /**
     * @return iterable
     */
    public function read(): iterable
    {
        $data = $this->buildQuery()->all();

        if($this->builder) {
            return array_map($this->builder, $data);
        }

        return $data;
    }

    /**
     * @return array|ActiveRecordInterface|null
     */
    public function readOne()
    {
        return $this->buildQuery()->one();
    }

    /**
     * @return Sort|null
     */
    public function getSort(): ?Sort
    {
        return $this->sorting;
    }

    /**
     * @return string
     */
    public function getSql(): string
    {
        return $this->buildQuery()->createCommand()->getRawSql();
    }

    /**
     * @return ActiveQueryInterface
     */
    private function buildQuery(): ActiveQueryInterface
    {
        $newQuery = clone $this->query;

        if($this->offset != null) {
            $newQuery->offset($this->offset);
        }

        if($this->limit != null) {
            $newQuery->limit($this->limit);
        }

        if($this->sorting != null) {
            $newQuery->orderBy($this->sorting->getCriteria());
        }

        return $newQuery;
    }
}
