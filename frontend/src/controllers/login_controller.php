<?php
include "dbconn.php";

function validate_jwt($token)
{
    if ($token !== 'validtoken') {
        return false;
    }

    return true;
}

header('Content-Type: application/json');

if (! isset($_SERVER['HTTP_AUTHORIZATION'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
list($jwt)  = sscanf($authHeader, 'Bearer %s');

if (! $jwt || ! validate_jwt($jwt)) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid token']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (empty($input['email']) || empty($input['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing parameters']);
        exit;
    }

    $email    = $input['email'];
    $password = $input['password'];

    $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE email = ?");
    if (! $stmt) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        http_response_code(500);
        echo json_encode(['error' => 'Server error']);
        exit;
    }
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($id, $password_hash);
    if ($stmt->fetch()) {
        if (password_verify($password, $password_hash)) {
            echo json_encode(['message' => 'Login successful', 'user_id' => $id]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid credentials']);
        }
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'User not found']);
    }
    $stmt->close();
}
