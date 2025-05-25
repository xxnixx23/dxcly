<?php

require_once '../db.php';

header('Content-type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $userId = $data['id'];

    //fetch data from the carts table
    $stmt = $pdo->prepare('SELECT * FROM carts WHERE user_id = ? AND status != "In Cart" ORDER BY cart_id ASC');
    $stmt->execute([$userId]);
    $carts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //return the data in JSON format
    echo json_encode($carts);
} catch (Exception $e) {
    echo json_encode(['error' => $e]);
}
