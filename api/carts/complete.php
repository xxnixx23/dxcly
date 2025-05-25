<?php
require_once '../db.php';

header('Content-type: application/json');
try {
    $data = json_decode(file_get_contents('php://input'), true);
    $cart_id = $data['cart_id'];
    $product_id = $data['product_id'];
    $cart_quantity = $data['cart_quantity'];

    // Update the 'status' field in carts table
    $stmt = $pdo->prepare('
            UPDATE carts
            SET status = ?
            WHERE cart_id = ?
        ');
    $stmt->execute([
        'Completed',
        $cart_id
    ]);

    // Decrease product_quantity by cart_quantity in the products table using product_id
    $stmt = $pdo->prepare('
            UPDATE products
            SET quantity = quantity - ?
            WHERE id = ?
        ');
    $stmt->execute([
        $cart_quantity,
        $product_id
    ]);


    echo json_encode(['message' => 'Thank you for ordering from us', 'success' => true]);
} catch (Exception $e) {
    echo json_encode(['message' => $e, "success" => false]);
}
