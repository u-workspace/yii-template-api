<?php


namespace App\Validator;


use Yiisoft\ActiveRecord\ActiveRecordFactory;
use Yiisoft\Validator\DataSetInterface;
use Yiisoft\Validator\HasValidationErrorMessage;
use Yiisoft\Validator\Result;
use Yiisoft\Validator\Rule;
use Closure;
use Yiisoft\Validator\ValidationContext;

class RecordExist extends Rule
{
    use HasValidationErrorMessage;

    /**
     * @var string
     */
    private string $message = 'Data does\'t exists';

    /**
     * @var callable $appendQuery
     */
    private $appendQuery;

    /**
     * @var callable $callback
     */
    private $callback;

    /**
     * @var bool
     */
    private bool $reverse = false;

    /**
     * @var bool
     */
    private bool $onlyExists = false;

    /**
     * RecordExist constructor.
     * @param ActiveRecordFactory $activeRecordFactory
     * @param string $entityName
     * @param Closure|null $closure
     * @param string $identity
     */
    public function __construct(
        private ActiveRecordFactory $activeRecordFactory,
        private string $entityName,
        private ?Closure $closure = null,
        private string $identity = 'ID'
    )
    {
    }

    protected function validateValue($value, ValidationContext $context = null): Result
    {

        $result = new Result();
        $query = $this->activeRecordFactory->createQueryTo($this->entityName)->andWhere([$this->identity => $value]);
        if($this->appendQuery) {
            $query = ($this->appendQuery)($query);
        }
        $record = $this->onlyExists ? $query->exists() : $query->one();

        $status = is_bool($record) ? !($record) : $this->isEmpty($record);

        if($this->reverse) {
            $status = !$status;
        }

        if ($status) {
            $result->addError($this->message);
            return $result;
        }

        if($this->closure) {
            $this->closure->call($this, $record);
        }

        if(is_callable($this->callback)) {
            ($this->callback)($record);
        }

        return $result;
    }

    /**
     * @return $this
     */
    public function reverse(): self
    {
        $new = clone $this;
        $new->reverse = true;
        return $new;
    }

    /**
     * @return $this
     */
    public function onlyExists(): self
    {
        $new = clone $this;
        $new->onlyExists = true;
        return $new;
    }

    /**
     * @param callable $appendQuery
     * @return $this
     */
    public function withAppendQuery(callable $appendQuery): self
    {
        $new = clone $this;
        $new->appendQuery = $appendQuery;
        return $new;
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function then(callable $callback): self
    {
        $new = clone $this;
        $new->callback = $callback;
        return $new;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setErrorMessage(string $message): self
    {
        $new = clone $this;
        $new->message = $message;
        return $new;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return array_merge(
            parent::getOptions(),
            [
                'message' => str_replace("{{entity}}", $this->entityName, $this->message),
            ],
        );
    }
}
