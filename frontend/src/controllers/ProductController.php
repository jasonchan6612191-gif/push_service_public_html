<?php
include("dbconn.php");
include("middleware_jwt.php");
header('Content-Type: application/json');

validate_jwt_token();

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $stmt = $conn->prepare("SELECT id, name, price, description FROM products");
    if (!$stmt) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        http_response_code(500);
        echo json_encode(['error' => 'Server error']);
        exit;
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    echo json_encode($products);
    $stmt->close();
} elseif ($method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (empty($input['name']) || empty($input['price']) || empty($input['description'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing parameters']);
        exit;
    }
    $name = $input['name'];
    $price = $input['price'];
    $description = $input['description'];
    $stmt = $conn->prepare("INSERT INTO products (name, price, description) VALUES (?, ?, ?)");
    if (!$stmt) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        http_response_code(500);
        echo json_encode(['error' => 'Server error']);
        exit;
    }
    $stmt->bind_param('sds', $name, $price, $description);
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Product created', 'product_id' => $stmt->insert_id]);
    } else {
        error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        http_response_code(500);
        echo json_encode(['error' => 'Create product failed']);
    }
    $stmt->close();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
