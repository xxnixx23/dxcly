<?php

require_once '../db.php';

header('Content-type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $name = $data['name'];
    $type = $data['type'];
    $price = $data['price'];
    $quantity = $data['quantity'];
    $description = $data['description'];
    $location = $data['location'];

    //update the product in the products table
    $stmt = $pdo->prepare('UPDATE products SET name = ?, type = ?, price = ?, quantity = ?, description = ?, location = ? WHERE id = ?');
    $stmt->execute([$name, $type, $price, $quantity, $description, $location, $id]);

    //return success in JSON format
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Product updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Product could not be updated']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Something went wrong']);
}
