<?php
session_start();
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_code = $_POST['code'];
    
    if ($user_code == $_SESSION['verification_code']) {
        $user = $_SESSION['user_data'];

        $full_name = $user['name'];
        $address = $user['address'];
        $email = $user['email'];
        $contact = $user['contact'];
        $username = $user['username'];
        $password = password_hash($user['password'], PASSWORD_DEFAULT);
        $account_type = 'buyer';
        $payment_method = 'GCash';
        $profile_picture = 'assets/default-pfp.png';

        $sql = "INSERT INTO users (full_name, address, email, contact_number, username, password, account_type, payment_method, profile_picture)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $full_name, $address, $email, $contact, $username, $password, $account_type, $payment_method, $profile_picture);

        if ($stmt->execute()) {
            unset($_SESSION['user_data']);
            unset($_SESSION['verification_code']);
            echo "<script>
                alert('Email successfully verified!');
                window.location.href = 'login.php';
            </script>";
            exit();
        } else {
            $error = "Database error: " . $stmt->error;
        }
    } else {
        $error = "Invalid verification code.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify Code</title>
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        form {
            background-color: #111;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
            width: 300px;
        }

        label {
            font-size: 14px;
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #222;
            border: 1px solid #555;
            color: #fff;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #fff;
            color: #000;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: #ddd;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Email Verification</h2>
    <form method="POST">
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <label>Enter the 6-digit code sent to your email:</label>
        <input type="text" name="code" maxlength="6" required>
        <button type="submit">Verify</button>
    </form>
</body>
</html>
