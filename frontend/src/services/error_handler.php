<?php
function log_error($message)
{
    error_log(date("[Y-m-d H:i:s] ") . $message . PHP_EOL, 3, __DIR__ . '/logs/error.log');
}

function respond_error($code, $user_message)
{
    http_response_code($code);
    echo json_encode(['error' => $user_message]);
    exit;
}

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    $msg = "PHP Error $errno: $errstr in $errfile on line $errline";
    log_error($msg);
    respond_error(500, "Internal server error");
});

set_exception_handler(function ($exception) {
    $msg = "Uncaught Exception: " . $exception->getMessage() . ' in ' . $exception->getFile() . ' on line ' . $exception->getLine();
    log_error($msg);
    respond_error(500, "Internal server error");
});

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null) {
        $msg = "Shutdown Error: {$error['message']} in {$error['file']} on line {$error['line']}";
        log_error($msg);
    }
});
