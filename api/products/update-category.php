
<?php
header('Content-Type: application/json');
require_once '../db.php';

// Get POST data
$data = json_decode(file_get_contents("php://input"), true);
$oldName = trim($data['old']);
$newName = trim($data['new']);

// Validate input
if (!$oldName || !$newName) {
    echo json_encode(['success' => false, 'message' => 'Invalid category names.']);
    exit;
}

// Check if new category name already exists
$stmt = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE name = ?");
$stmt->execute([$newName]);
if ($stmt->fetchColumn() > 0) {
    echo json_encode(['success' => false, 'message' => 'Category name already exists.']);
    exit;
}

// Update category name
$stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE name = ?");
if ($stmt->execute([$newName, $oldName])) {
    echo json_encode(['success' => true, 'message' => 'Category updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update category.']);
}
?>
