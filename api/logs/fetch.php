<?php

require_once '../db.php';

header('Content-type: application/json');

try {
    //fetch data from the products table
    $stmt = $pdo->prepare('SELECT * FROM logs');
    $stmt->execute();
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //return the data in JSON format
    echo json_encode($logs);
} catch (Exception $e) {
    echo json_encode(['error' => $e]);
}
