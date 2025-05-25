<?php

require_once '../db.php';

header('Content-type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $current_password = $pdo->query("SELECT password FROM users WHERE id = '$id'")->fetch()['password'];
    $username = $pdo->query("SELECT username FROM users WHERE id = '$id'")->fetch()['username'];
    $accountType = $pdo->query("SELECT account_type FROM users WHERE id = '$id'")->fetch()['account_type'];

    //check if the password is not equal to the current password
    if ($password != $current_password) {
        //update the password
        $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->execute([$password, $id]);

        //check if the query succeeded or not
        if ($stmt->rowCount() > 0) {
            //return the data in JSON format
            echo json_encode(['message' => 'Password updated successfully', 'success' => true, 'username' => $username, 'accountType' => $accountType]);
        } else {
            echo json_encode(['message' => 'Password not updated', 'success' => false]);
        }
    } else {
        echo json_encode(['message' => 'Password is the same as the current password', 'success' => false]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e]);
}
