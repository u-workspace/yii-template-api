<?php
declare(strict_types=1);

namespace App\Helper\Password;

use Yiisoft\Security\PasswordHasher;

class Hash
{
    /**
     * For hashing password
     *
     * @param string $password
     * @return string
     */
    public static function hash(string $password): string
    {
        return (new PasswordHasher())->hash($password);
    }

    /**
     * For compare hashed value with another string
     *
     * @param string $password
     * @param string $hashValue
     * @return bool
     */
    public static function validate(string $password, string $hashValue): bool
    {
        return (new PasswordHasher())->validate($password, $hashValue);
    }
}
