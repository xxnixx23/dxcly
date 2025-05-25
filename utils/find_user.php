
<?php

require_once '../api/db.php';

header('Content-type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data;

    //fetch data from the users table
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //return the data in JSON format
    if ($user) {
        echo json_encode(['success' => true, 'id' => $user['id']]);
    } else {
        echo json_encode(['message' => 'Email not found', 'success' => false]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e]);
}
