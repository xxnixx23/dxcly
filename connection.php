<?php
$serverName = $_SERVER['SERVER_NAME'] ?? 'localhost';
if ($serverName === 'localhost' || $serverName === '127.0.0.1') {
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'dxcly';
} else {
    $db_host = 'localhost';
    $db_user = 'u801377270_dxcly_2025';
    $db_pass = 'Dxcly_2025';
    $db_name = 'u801377270_dxcly_2025';
}
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}