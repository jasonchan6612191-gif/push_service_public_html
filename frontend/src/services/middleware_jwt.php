<?php
function validate_jwt_token()
{
    if (! isset($_SERVER['HTTP_AUTHORIZATION'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }

    $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
    list($jwt)  = sscanf($authHeader, 'Bearer %s');

    if (! $jwt || $jwt !== 'validtoken') {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }
}
