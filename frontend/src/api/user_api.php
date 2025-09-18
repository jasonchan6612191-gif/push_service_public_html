<?php
include "dbconn.php";
include "middleware_jwt.php";
header('Content-Type: application/json');

validate_jwt_token();

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    if (! isset($_GET['user_id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing user_id']);
        exit;
    }
    $user_id = $_GET['user_id'];
    $stmt    = $conn->prepare("SELECT id, email, name FROM users WHERE id = ?");
    if (! $stmt) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        http_response_code(500);
        echo json_encode(['error' => 'Server error']);
        exit;
    }
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user   = $result->fetch_assoc();
    if ($user) {
        echo json_encode($user);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
    }
    $stmt->close();
} elseif ($method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (empty($input['email']) || empty($input['name'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing parameters']);
        exit;
    }
    $email = $input['email'];
    $name  = $input['name'];
    $stmt  = $conn->prepare("INSERT INTO users (email, name) VALUES (?, ?)");
    if (! $stmt) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        http_response_code(500);
        echo json_encode(['error' => 'Server error']);
        exit;
    }
    $stmt->bind_param('ss', $email, $name);
    if ($stmt->execute()) {
        echo json_encode(['message' => 'User created', 'user_id' => $stmt->insert_id]);
    } else {
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        http_response_code(500);
        echo json_encode(['error' => 'Create user failed']);
    }
    $stmt->close();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
