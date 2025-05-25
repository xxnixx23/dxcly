<?php

require_once '../db.php';

header('Content-type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $userId = $data['userId'];
    $productId = $data['productId'];

    //insert the data into the cart table
    $stmt = $pdo->prepare('INSERT INTO carts (user_id, product_id) VALUES (?, ?)');
    $stmt->execute([$userId, $productId]);

    //return the data in JSON format
    echo json_encode(['message' => 'Product added to cart successfully']);
} catch (Exception $e) {
    echo json_encode(['error' => $e, 'user' => $userId, 'product' => $productId]);
}
