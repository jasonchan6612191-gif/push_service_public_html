<?php
namespace services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . '/../vendor/autoload.php';

class JwtAuth
{
    private static $secret_key;

    // 初始化密鑰建議從環境變數讀取
    public static function init()
    {
        self::$secret_key = getenv('JWT_SECRET_KEY');
        if (! self::$secret_key) {
            throw new \Exception('JWT secret key is not set in environment variables.');
        }
    }

    // 編碼 JWT，輸入參數 payload 應為非空陣列
    public static function encode(array $payload)
    {
        if (empty($payload)) {
            throw new \InvalidArgumentException('Payload for JWT encode cannot be empty.');
        }
        return JWT::encode($payload, self::$secret_key, 'HS256');
    }

    // 解碼 JWT，回傳物件或 null
    public static function decode(string $jwt)
    {
        if (empty($jwt)) {
            throw new \InvalidArgumentException('JWT token cannot be empty.');
        }
        try {
            $decoded = JWT::decode($jwt, new Key(self::$secret_key, 'HS256'));
            return $decoded;
        } catch (\Firebase\JWT\ExpiredException $e) {
            // Token 過期特別處理
            throw new \Exception('JWT token expired.');
        } catch (\Exception $e) {
            // 總錯誤捕獲
            throw new \Exception('Invalid JWT token: ' . $e->getMessage());
        }
    }
}
