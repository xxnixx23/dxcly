<?php

require_once '../db.php';

header('Content-type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $operation = $data['operation'];
    $cart_id = $data['cart_id'];

    //insert the data into the cart table
    if ($operation === 'increase') {
        $stmt = $pdo->prepare('UPDATE carts SET cart_quantity = cart_quantity + 1 WHERE cart_id = ?');

        $result = $stmt->execute([$cart_id]);
    } elseif ($operation === 'decrease') {
        $stmt = $pdo->prepare('UPDATE carts SET cart_quantity = cart_quantity - 1 WHERE cart_id = ?');

        $result = $stmt->execute([$cart_id]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e, 'success' => false]);
}
