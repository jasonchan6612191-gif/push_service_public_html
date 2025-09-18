<?php
include "dbconn.php";
include "middleware_jwt.php";
header('Content-Type: application/json');

validate_jwt_token();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (! isset($_FILES['file'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing file']);
        exit;
    }

    $file       = $_FILES['file'];
    $upload_dir = __DIR__ . '/uploads/';

    if (! is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $target_file = $upload_dir . basename($file['name']);

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        echo json_encode(['message' => 'File uploaded', 'filename' => basename($file['name'])]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to upload file']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
