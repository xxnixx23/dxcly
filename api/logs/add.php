<?php

require_once '../db.php';

header('Content-type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $userId = $data['userId'];
    $action = $data['action'];
    $username = $data['username'];

    //insert the data into the cart table
    $stmt = $pdo->prepare('INSERT INTO logs (user_id, action, user_name) VALUES (?, ?, ?)');
    $stmt->execute([$userId, $action, $username]);
} catch (Exception $e) {
    echo json_encode(['error' => $e]);
}
