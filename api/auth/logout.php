<?php
require_once '../db.php';

//Set the content type to JSON
header('Content-type: application/json');

try {
    session_start();

    if (isset($_SESSION['id']) && isset($_SESSION['logged_in'])) {

        $userId = $_SESSION['id'];
        $accountType = $_SESSION['account_type'];

        $_SESSION['logged_in'] = false;
        $_SESSION['id'] = '';
        $_SESSION['account_type'] = '';

        echo json_encode(['message' => 'Logout Successful', 'success' => 'true', 'userId' => $userId, 'accountType' => $accountType]);
    } else {
        echo json_encode(['message' => 'No existing session found', 'success' => 'false']);
    }
} catch (Exception $e) {
    echo json_encode(['message' => 'Logout Failed', 'success' => 'false', 'error' => $e]);
}
