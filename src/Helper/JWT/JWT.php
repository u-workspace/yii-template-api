<?php
declare(strict_types=1);

namespace App\Helper\JWT;

use Firebase\JWT\JWT as BaseJWT;
use Exception;

class JWT
{
    /**
     * Key for JWT Token
     * @var string
     */
    public static $key = "key";

    /**
     * Build JWT Token
     * @param array $payload
     *
     * @return string
     */
    public static function generateToken(array $payload): string {
        $token = BaseJWT::encode($payload, self::$key);

        return $token;
    }

    /**
     * Decode JWT Token
     * @param string $token
     *
     * @return array
     */
    public static function decodeToken(string $token): array {
        try {
            $data = BaseJWT::decode($token, self::$key, array('HS256'));

            return [
                'status' => true,
                'data' => $data
            ];
        } catch(Exception $exception) {
            return [
                'status' => false,
                'data' => $exception->getMessage()
            ];
        }
    }
};


