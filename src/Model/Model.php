<?php
declare(strict_types=1);

namespace App\Model;

use App\Data\ArrayableTrait;
use IteratorAggregate;
use Yiisoft\ActiveRecord\ActiveRecord;
use Yiisoft\ActiveRecord\ActiveRecordFactory;
use Yiisoft\Db\Connection\ConnectionInterface;

class Model extends ActiveRecord implements IteratorAggregate
{
    use ArrayableTrait;

    /**
     * @var Schema
     */
    protected Schema $schema;

    /**
     * Model constructor.
     * @param ConnectionInterface $db
     * @param Schema $schema
     * @param ActiveRecordFactory|null $activeRecordFactory
     */
    public function __construct(ConnectionInterface $db, Schema $schema, ActiveRecordFactory $activeRecordFactory = null)
    {
        parent::__construct($db, $activeRecordFactory);
        $this->schema = $schema;
    }
}
