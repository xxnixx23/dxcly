<?php
require_once '../db.php';

header('Content-type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $cart_id = $data['id'];

    $daysToAdd = rand(1, 14); // Update to generate a random date between 7 to 14 days in the future
    $randomDate = date('Y-m-d H:i:s', strtotime("+{$daysToAdd} days"));

    $stmt = $pdo->prepare('
            UPDATE carts
            SET status = ?, received_date = ?
            WHERE cart_id = ?
        ');
    $stmt->execute([
        'To Receive',
        $randomDate,
        $cart_id
    ]);

    echo json_encode(['message' => 'Payment Successful', 'success' => true]);
} catch (Exception $e) {
    echo json_encode(['message' => $e, "success" => false]);
}
