<?php
$serverName = $_SERVER['SERVER_NAME'] ?? 'localhost';

if ($serverName === 'localhost') {
    $db_host = 'localhost';
    $db_name = 'dxcly';
    $db_user = 'root';
    $db_pass = '';
} else {
    $db_host = 'localhost';
    $db_name = 'u801377270_dxcly_2025';
    $db_user = 'u801377270_dxcly_2025';
    $db_pass = 'Dxcly_2025';
}

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}