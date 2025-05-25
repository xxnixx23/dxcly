<?php
include("connection.php");
session_start();

if (!isset($_SESSION['reset_email'])) {
    echo "<script>alert('Unauthorized access.'); window.location.href='forgot_password.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $email = $_SESSION['reset_email'];

        // You can hash the password here (optional but recommended)
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);

        if ($stmt->execute()) {
            // Clear session and redirect
            unset($_SESSION['reset_email']);
            unset($_SESSION['forgot_password_code']);
            echo "<script>alert('Password updated successfully!'); window.location.href='login.php';</script>";
            exit();
        } else {
            $error = "Failed to update password.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - DXCLY</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>

<?php include "templates/header.php"; ?>

<div class="content">
    <div class="register-container">
        <form method="POST" action="">
            <h2>Reset Password</h2>
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <div class="input">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" required minlength="8">
            </div>
            <div class="input">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required minlength="8">
            </div>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</div>

<?php include "templates/footer.php"; ?>

</body>
</html>
