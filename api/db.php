<?php 
$host = 'localhost';
$dbname = 'dxcly';

try{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("Database connection failed: " . $e->getMessage());
}
?>