<?php

require_once '../db.php';

header('Content-type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];

    //fetch data from the products table
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //return the data in JSON format
    echo json_encode($user);
} catch (Exception $e) {
    echo json_encode(['error' => $e]);
}
