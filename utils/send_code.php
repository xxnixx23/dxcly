<?php
header('Content-Type: application/json');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../connection.php';
session_start();

// Get JSON data
$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';

// Validate email
if (empty($email)) {
    echo json_encode(["success" => false, "message" => "Email is required."]);
    exit();
}

// Check if email exists
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $conn->error
    ]);
    exit();
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode(["success" => false, "message" => "Email does not exist in our records."]);
    exit();
}

// Generate and store verification code
$verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
$_SESSION['verification_code'] = $verification_code;
$_SESSION['reset_email'] = $email;

// Send email
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreply@dxclywear.shop';
    $mail->Password = 'Dxcly_2025'; // your app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 465;

    $mail->setFrom('noreply@dxclywear.shop', 'DXCLY');
    $mail->addAddress($email);
    $mail->Subject = 'Password Reset Code';
    $mail->isHTML(true);
    $mail->Body = "<p>Your password reset code is: <b style='font-size: 30px;'>$verification_code</b></p>";

    $mail->send();

    echo json_encode([
        "success" => true,
        "message" => "Verification code sent to your email."
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Failed to send email: " . $mail->ErrorInfo
    ]);
}
