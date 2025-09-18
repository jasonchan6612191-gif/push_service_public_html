<?php
putenv('JWT_SECRET_KEY=supersecretkey123');

require_once __DIR__ . '/../services/JwtAuth.php';

use services\JwtAuth;

header('Content-Type: application/json');

try {
    JwtAuth::init();

    $headers = null;
    // 確保能取到 Authorization Header
    if (function_exists('apache_request_headers')) {
        $headers = apache_request_headers();
    } else {
        // fallback for non-Apache, 如非 Apache 就用 $_SERVER
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (strtolower($name) == 'http_authorization') {
                $headers['Authorization'] = $value;
                break;
            }
        }
    }

    // 在某些伺服器環境下，HTTP_AUTHORIZATION 可能是空，需要嘗試其他變數
    if (empty($headers)) {
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers['Authorization'] = $_SERVER['HTTP_AUTHORIZATION'];
        } elseif (function_exists('getallheaders')) {
            $allHeaders = getallheaders();
            if (isset($allHeaders['Authorization'])) {
                $headers['Authorization'] = $allHeaders['Authorization'];
            }
        }
    }

    if (! $headers || ! isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Authorization header missing']);
        exit;
    }

    $authHeader = $headers['Authorization'];
    list($jwt)  = sscanf($authHeader, 'Bearer %s');

    if (! $jwt) {
        http_response_code(401);
        echo json_encode(['error' => 'Token not found in Authorization header']);
        exit;
    }

    $decoded = JwtAuth::decode($jwt);

    // 驗證成功，輸出用戶資訊或業務邏輯
    echo json_encode(['message' => 'Access granted', 'user' => $decoded]);

} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(['error' => $e->getMessage()]);
}
