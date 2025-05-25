<?php
require_once '../db.php';

//Set the content type to JSON
header('Content-type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $fullName = $data['name'];
    $address = $data['address'];
    $email = $data['email'];
    $contactNumber = $data['contact'];
    $username = $data['username'];
    $password = $data['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $account_type = 'buyer';

    $stmtEmail = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmtEmail->execute([$email]);
    $userEmail = $stmtEmail->fetch(PDO::FETCH_ASSOC);

    $stmtUsername = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
    $stmtUsername->execute([$username]);
    $userUsername = $stmtUsername->fetch(PDO::FETCH_ASSOC);

    if ($userEmail || $userUsername) {
        if ($userEmail) {
            echo json_encode(['message' => 'Email already exists', 'success' => false]);
        } else {
            echo json_encode(['message' => 'Username already exists', 'success' => false]);
        }
    } else {
        $stmt = $pdo->prepare('INSERT INTO users (full_name, address, email, contact_number, username, password, account_type) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$fullName, $address, $email, $contactNumber, $username, $hashedPassword, $account_type]);

        echo json_encode(['message' => 'Sign up successful', 'success' => true]);
    }
} catch (Exception $e) {
    echo json_encode(['message' => $e, 'success' => false]);
}
