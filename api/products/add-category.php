<?php

require_once '../db.php';

header('Content-type: application/json');

try {
    // Decode the JSON input
    $data = json_decode(file_get_contents('php://input'), true);

    $name = trim($data['name'] ?? '');

    // Validate the name
    if (empty($name)) {
        echo json_encode(['success' => false, 'message' => 'Category name is required']);
        return;
    }

    // Check if category already exists
    $stmt = $pdo->prepare('SELECT * FROM categories WHERE name = ?');
    $stmt->execute([$name]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Category already exists']);
        return;
    }

    // Insert the new category
    $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
    $stmt->execute([$name]);

    echo json_encode(['success' => true, 'message' => 'Category added successfully']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Something went wrong']);
}
