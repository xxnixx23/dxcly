<?php

require_once '../db.php';

session_start();

header('Content-type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $_SESSION['id'];
    $name = $data['name'];
    $username = $data['username'];
    $email = $data['email'];
    $contact = $data['contact'];
    $address = $data['address'];
    $method = $data['method'];
    $location = $data['location'];

    //check if the username is already existing in the users table except the current username
    $stmt = $pdo->prepare('SELECT COUNT(*) as count FROM users WHERE username = ? AND id != ?');
    $stmt->execute([$username, $id]);
    $usernameCount = $stmt->fetchColumn();

    if ($usernameCount > 0) {
        echo json_encode(['message' => 'Username is already existing', "success" => "false"]);
        return;
    }

    //check if the email is already existing in the users table except the current email
    $stmt = $pdo->prepare('SELECT COUNT(*) as count FROM users WHERE email = ? AND id != ?');
    $stmt->execute([$email, $id]);
    $emailCount = $stmt->fetchColumn();

    if ($emailCount > 0) {
        echo json_encode(['message' => 'Email is already existing', "success" => "false"]);
        return;
    }

    //update the data in the users table
    $stmt = $pdo->prepare('UPDATE users SET full_name = ?, username = ?, email = ?, contact_number = ?, address = ?, payment_method = ?, profile_picture = ? WHERE id = ?');
    $stmt->execute([$name, $username, $email, $contact, $address, $method, $location, $id]);

    //return the data in JSON format
    echo json_encode(['message' => 'User data updated successfully', "success" => "true", 'id' => $id]);
} catch (Exception $e) {
    echo json_encode(['message' => $e]);
}
