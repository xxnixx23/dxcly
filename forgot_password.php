<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
include("connection.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if the email exists in the users table
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Email not found in the database.'); window.history.back();</script>";
        exit();
    }

    // Email exists, generate verification code
    $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
    $_SESSION['forgot_password_code'] = $verification_code;
    $_SESSION['reset_email'] = $email;

    // Send email
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'itsyourgirlnikkiella@gmail.com';
        $mail->Password = 'fjbo sfrt ajfm ddlb'; // new app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('itsyourgirlnikkiella@gmail.com', 'DXCLY');
        $mail->addAddress($email);
        $mail->Subject = 'Password Reset Verification';
        $mail->isHTML(true);
        $mail->Body = '<p>Your password reset code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';

        $mail->send();

        // Redirect to a page to enter the code (e.g., verify_reset.php)
        header("Location: verify_reset.php");
        exit();
    } catch (Exception $e) {
        echo "<script>alert('Failed to send email: " . $mail->ErrorInfo . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - DXCLY</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>

<?php include "templates/header.php"; ?>

<div class="content">
    <div class="register-container">
        <form method="POST" action="">
            <h2>Forgot Password</h2>
            <div class="input">
                <label for="email">Enter your registered email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit">Send Verification Code</button>
            <a href="login.php" class="login"><span>Back to Login</span></a>
        </form>
    </div>
</div>

<?php include "templates/footer.php"; ?>

</body>
</html>
