<?php
require_once 'db.php';

//Set the content type to JSON
header('Content-type: application/json');

//handle HTTP methods
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        try {
            //Fetch all users
            $stmt = $pdo->query('SELECT * from users');
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($result);
        } catch (Exception $e) {
            echo $e;
            echo json_encode(['message' => 'Something went wrong.']);
        }
        break;
    case 'POST':
        try {
            //Add a new user
            $data = json_decode(file_get_contents('php://input'), true);
            $fullName = $data['full_name'];
            $address = $data['address'];
            $email = $data['email'];
            $contactNumber = $data['contact_number'];
            $username = $data['username'];
            $password = $data['password'];
            $account_type = $data['account_type'];

            $stmt = $pdo->prepare('INSERT INTO users (full_name, address, email, contact_number, username, password, account_type) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$fullName, $address, $email, $contactNumber, $username, $password, $account_type]);

            echo json_encode(['message' => 'User added successfully', 'user' => $data]);
        } catch (Exception $e) {
            echo $e;
            echo json_encode(['message' => 'Something went wrong.']);
        }
        break;
    case 'PATCH':
        try {
            //Update a user
            $data = json_decode(file_get_contents('php://input'), true);

            $id = $data['id'];
            $fullName = $data['full_name'];
            $address = $data['address'];
            $email = $data['email'];
            $contactNumber = $data['contact_number'];
            $username = $data['username'];
            $password = $data['password'];
            $account_type = $data['account_type'];

            $stmt = $pdo->prepare('UPDATE users SET full_name=?, address=?, email=?, contact_number=?, username=?, password=?, account_type=? WHERE id=?');
            $stmt->execute([$fullName, $address, $email, $contactNumber, $username, $password, $account_type, $id]);

            echo json_encode(['message' => 'User updated successfully', 'user' => $data]);
        } catch (Exception $e) {
            echo $e;
            echo json_encode(['message' => 'Something went wrong.']);
        }
        break;
    case 'DELETE':
        try {

            //Removes a user
            $data = json_decode(file_get_contents('php://input'), true);

            $id = $data['id'];

            $stmt = $pdo->prepare('DELETE FROM users WHERE id=?');
            $stmt->execute([$id]);

            echo json_encode(['message' => 'User deleted successfully']);
        } catch (Exception $e) {
            echo $e;
            echo json_encode(['message' => 'Something went wrong.']);
        }
        break;
    default:
        //Invalid method
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
