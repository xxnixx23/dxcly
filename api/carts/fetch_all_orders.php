<?php

require_once '../db.php';

header('Content-type: application/json');

try {
    //fetch data from the carts table
    $stmt = $pdo->prepare('SELECT * FROM carts WHERE status != "In Cart" ORDER BY cart_id ASC');
    $stmt->execute();
    $carts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //return the data in JSON format
    echo json_encode($carts);
} catch (Exception $e) {
    echo json_encode(['error' => $e]);
}
