<?php
declare(strict_types=1);

namespace App\Model;

use Yiisoft\Arrays\ArrayHelper;

class Schema
{
    /**
     * @var string|null
     */
    private ?string $main = null;

    /**
     * Schema constructor.
     * @param array $schemas
     */
    public function __construct(array $schemas)
    {
        $this->main = ArrayHelper::getValue($schemas, 'main');
    }

    /**
     * @return string|null
     */
    public function getMain(): ?string
    {
        return $this->main;
    }
}
