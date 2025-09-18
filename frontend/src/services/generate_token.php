<?php
require_once __DIR__ . '/../services/JwtAuth.php'; // 路徑根據實際修改

use services\JwtAuth;

putenv('JWT_SECRET_KEY=supersecretkey123');
JwtAuth::init();

$payload = [
    'user_id'  => 1,
    'username' => 'testuser',
    'iat'      => time(),
    'exp'      => time() + 3600,
];

$token = JwtAuth::encode($payload);
echo $token . PHP_EOL;
