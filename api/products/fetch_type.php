<?php

require_once '../db.php';

header('Content-type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $type = $data['type'];

    //fetch data from the products table
    $stmt = $pdo->prepare('SELECT id, name, location, price FROM products WHERE type = ?');
    $stmt->execute([$type]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //return the data in JSON format
    echo json_encode($products);
} catch (Exception $e) {
    echo json_encode(['error' => $e]);
}
