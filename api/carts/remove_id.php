<?php

require_once '../db.php';

header('Content-type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $cartId = $data['id'];

    //delete the order from the orders table
    $stmt = $pdo->prepare('DELETE FROM carts WHERE cart_id = ?');
    $stmt->execute([$cartId]);

    //return success message in JSON format
    echo json_encode(['success' => 'true']);
} catch (Exception $e) {
    echo json_encode(['error' => $e, 'success' => 'false']);
}
