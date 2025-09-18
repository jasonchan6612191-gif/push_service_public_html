<?php
$servername = "localhost";
$username   = "ibubbleivlc";
$password   = "Hijolin520";
$dbname     = "ibubbleivlc_ivlc";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
    exit;
}
