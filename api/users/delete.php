<?php
session_start();
header('Content-Type: application/json');

// Log the session contents to help debug
error_log(print_r($_SESSION, true)); // Check PHP error log for output

// Check if the user is an admin
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'admin') {
    echo json_encode([
        "success" => false,
        "message" => "Unauthorized access",
        "color" => "red",
        "icon" => "x"
    ]);
    exit;
}

// Check if required POST data is present
if (!isset($_POST['user_id'], $_POST['admin_password'])) {
    echo json_encode([
        "success" => false,
        "message" => "Missing data",
        "color" => "red",
        "icon" => "x"
    ]);
    exit;
}

require '../../connection.php'; // Adjust path as needed

$adminUsername = $_SESSION['username'];
$adminPassword = $_POST['admin_password'];
$userIdToDelete = intval($_POST['user_id']);

// Get hashed admin password from DB
$stmt = $conn->prepare("SELECT password FROM users WHERE username = ? AND account_type = 'admin'");
$stmt->bind_param("s", $adminUsername);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo json_encode([
        "success" => false,
        "message" => "Admin not found",
        "color" => "red",
        "icon" => "x"
    ]);
    exit;
}

$adminData = $result->fetch_assoc();

// Verify the entered password against the hash
if (!password_verify($adminPassword, $adminData['password'])) {
    echo json_encode([
        "success" => false,
        "message" => "Incorrect password",
        "color" => "red",
        "icon" => "x"
    ]);
    exit;
}

// Proceed to delete user
$deleteStmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$deleteStmt->bind_param("i", $userIdToDelete);

if ($deleteStmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Deleted successfully",
        "color" => "green",
        "icon" => "check"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Failed to delete user",
        "color" => "red",
        "icon" => "x"
    ]);
}
