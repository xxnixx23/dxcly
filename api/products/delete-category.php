<?php
header('Content-Type: application/json');
require_once '../db.php';

// Get POST data
$data = json_decode(file_get_contents("php://input"), true);
$category = trim($data['category']);

// Validate input
if (!$category) {
    echo json_encode(['success' => false, 'message' => 'Invalid category name.']);
    exit;
}

// Delete category
$stmt = $pdo->prepare("DELETE FROM categories WHERE name = ?");
if ($stmt->execute([$category])) {
    echo json_encode(['success' => true, 'message' => 'Category deleted successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete category.']);
}
?>
