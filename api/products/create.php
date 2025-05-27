<?php

require_once '../db.php';

header('Content-type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'];
    $type = $data['type'];
    $price = $data['price'];
    $quantity = $data['quantity'];
    $description = $data['description'];
    $location = $data['location'];


    //check if the product doesn't exist in the database
    $stmt = $pdo->prepare('SELECT * FROM products WHERE name = ? AND type = ?');
    $stmt->execute([$name, $type]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Product already exists']);
        return;
    }

    //insert the product into the products table
    $stmt = $pdo->prepare('INSERT INTO products (name, type, price, quantity, description, location) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$name, $type, $price, $quantity, $description, $location]);

    //return success in JSON format
    echo json_encode(['success' => true, 'message' => 'Product created successfully']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Something went wrong']);
}