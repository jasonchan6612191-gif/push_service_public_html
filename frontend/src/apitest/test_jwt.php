<?php
require_once __DIR__ . '/../services/JwtAuth.php'; // 依你的目錄結構調整路徑

use services\JwtAuth;

try {
    JwtAuth::init();
    $payload = ['user_id' => 'tester'];
    $token   = JwtAuth::encode($payload);
    echo "Token: " . $token;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
