<?php
include "dbconn.php";
include "middleware_jwt.php";
header('Content-Type: application/json');

validate_jwt_token();

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $stmt = $conn->prepare("SELECT id, question, answer FROM faq");
    if (! $stmt) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        http_response_code(500);
        echo json_encode(['error' => 'Server error']);
        exit;
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $faqs   = [];
    while ($row = $result->fetch_assoc()) {
        $faqs[] = $row;
    }
    echo json_encode($faqs);
    $stmt->close();
} elseif ($method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (empty($input['question']) || empty($input['answer'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing parameters']);
        exit;
    }
    $question = $input['question'];
    $answer   = $input['answer'];
    $stmt     = $conn->prepare("INSERT INTO faq (question, answer) VALUES (?, ?)");
    if (! $stmt) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        http_response_code(500);
        echo json_encode(['error' => 'Server error']);
        exit;
    }
    $stmt->bind_param('ss', $question, $answer);
    if ($stmt->execute()) {
        echo json_encode(['message' => 'FAQ added', 'faq_id' => $stmt->insert_id]);
    } else {
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        http_response_code(500);
        echo json_encode(['error' => 'Create FAQ failed']);
    }
    $stmt->close();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
