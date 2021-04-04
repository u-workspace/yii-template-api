<?php
declare(strict_types=1);

namespace App\Helper\Request;

use App\Helper\JWT\JWT;
use Yiisoft\ActiveRecord\ActiveRecordFactory;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Factory\Exceptions\InvalidConfigException;

class Access
{
    /**
     * @var string
     */
    public const ROLES = [];

    /**
     * @var string|null
     */
    private ?string $requestAs = "";

    /**
     * @param string|null $token
     * @param string|null $requestAs
     * @param ActiveRecordFactory $activeRecordFactory
     * @throws InvalidConfigException
     */
    public function setAccess(?string $token, ?string $requestAs, ActiveRecordFactory $activeRecordFactory)
    {
        if (in_array($requestAs, self::ROLES)) {
            $this->requestAs = $requestAs;
        }

        if ($token) {
            $dataToken = JWT::decodeToken($token);
            if (ArrayHelper::getValue($dataToken, 'status', false)) {

            }
        }
    }

    /**
     * @return string
     */
    public function getRequestAs(): string
    {
        return $this->requestAs;
    }
}
