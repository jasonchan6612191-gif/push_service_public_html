<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

require_once 'config/dbconn.php';
require_once 'src/controllers/UserController.php';
require_once 'src/controllers/PushController.php';
require_once 'src/controllers/ThirdPartyAccountController.php';
require_once 'src/controllers/OtpController.php';
require_once 'src/controllers/PasswordController.php';

$method   = $_SERVER['REQUEST_METHOD'];
$path     = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($path, '/'));

$userController       = new UserController($conn);
$pushController       = new PushController($conn);
$thirdPartyController = new ThirdPartyAccountController($conn);
$otpController        = new OtpController($conn);
$passwordController   = new PasswordController($conn);

switch ($segments[1] ?? '') {
    case 'user':
        handleUserAPI($method, $segments);
        break;
    case 'push':
        handlePushAPI($method, $segments);
        break;
    case 'thirdparty':
        handleThirdPartyAPI($method, $segments);
        break;
    case 'otp':
        handleOtpAPI($method, $segments);
        break;
    case 'password':
        handlePasswordAPI($method, $segments);
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Not found']);
}

function handleUserAPI($method, $segments)
{
    global $userController, $conn;
    if ($method === 'GET' && isset($segments[2])) {
        $id   = intval($segments[2]);
        $stmt = $conn->prepare("SELECT id, full_name, email, mobile, status FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($user = $result->fetch_assoc()) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }
}

function handlePushAPI($method, $segments)
{
    echo json_encode(['message' => 'Push API endpoint']);
}

function handleThirdPartyAPI($method, $segments)
{
    global $thirdPartyController;
    if ($method === 'POST' && $segments[2] === 'link') {
        $data        = json_decode(file_get_contents('php://input'), true);
        $userId      = $data['userId'] ?? null;
        $provider    = $data['provider'] ?? null;
        $accountData = $data['accountData'] ?? null;
        if ($thirdPartyController->linkAccount($userId, $provider, $accountData)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }

    } elseif ($method === 'POST' && $segments[2] === 'unlink') {
        $data     = json_decode(file_get_contents('php://input'), true);
        $userId   = $data['userId'] ?? null;
        $provider = $data['provider'] ?? null;
        if ($thirdPartyController->unlinkAccount($userId, $provider)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }

    }
}

function handleOtpAPI($method, $segments)
{
    global $otpController;
    $data = json_decode(file_get_contents('php://input'), true);
    if ($method === 'POST' && $segments[2] === 'send') {
        $phone = $data['phone'] ?? null;
        $otp   = $otpController->sendOtp($phone);
        if ($otp) {
            echo json_encode(['success' => true, 'otp' => $otp]);
        } else {
            echo json_encode(['success' => false]);
        }

    } elseif ($method === 'POST' && $segments[2] === 'verify') {
        $phone = $data['phone'] ?? null;
        $code  = $data['code'] ?? null;
        if ($otpController->verifyOtp($phone, $code)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }

    } elseif ($method === 'POST' && $segments[2] === 'unbind') {
        $phone = $data['phone'] ?? null;
        if ($otpController->unbindOtp($phone)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }

    }
}

function handlePasswordAPI($method, $segments)
{
    global $passwordController;
    $data = json_decode(file_get_contents('php://input'), true);
    if ($method === 'POST' && $segments[2] === 'change') {
        $userId  = $data['userId'] ?? null;
        $oldPass = $data['oldPassword'] ?? null;
        $newPass = $data['newPassword'] ?? null;
        if ($passwordController->changePassword($userId, $oldPass, $newPass)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }

    }
}
