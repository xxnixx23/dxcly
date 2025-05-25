<?php

// header('Content-type: application/json');

$uploadDir = '../assets/';
$uploadedFile = $uploadDir . basename($_FILES['picture']['name']);

if (move_uploaded_file($_FILES['picture']['tmp_name'], $uploadedFile)) {
    $relativePath = "assets/" . basename($_FILES['picture']['name']);
    echo json_encode(['message' => 'Upload Successful', 'success' => 'true', 'relativePath' => $relativePath]);
} else {
    echo json_encode(['message' => 'Upload Failed', 'success' => 'false']);
}
