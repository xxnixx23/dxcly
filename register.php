<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

include("connection.php");

session_start();

// Database connection check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['name'])) {
    // Sanitize inputs
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
    $username = htmlspecialchars(trim($_POST['username']), ENT_QUOTES, 'UTF-8');
    $contact = htmlspecialchars(trim($_POST['contact']), ENT_QUOTES, 'UTF-8');
    $address = htmlspecialchars(trim($_POST['address']), ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Check password match
    if ($password !== $confirm_password) {
        echo "<script>alert('Password and Confirm Password do not match.'); window.history.back();</script>";
        exit();
    }

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE userName = ? OR email = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Username or Email already exists. Please use a different one.'); window.history.back();</script>";
        exit();
    }

    // Save user data in session for later use (do NOT store raw password in session in production!)
    $_SESSION['user_data'] = [
        'email' => $email,
        'name' => $name,
        'username' => $username,
        'contact' => $contact,
        'address' => $address,
        'password' => $password
    ];

    // Generate 6-digit verification code
    $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
    $_SESSION['verification_code'] = $verification_code;

    // Send verification email with PHPMailer
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'itsyourgirlnikkiella@gmail.com';
        $mail->Password = 'pdcb lfyw biaa xtva'; // your new app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('itsyourgirlnikkiella@gmail.com', 'DXCLY');
        $mail->addReplyTo('itsyourgirlnikkiella@gmail.com', 'DXCLY Support');
        $mail->addAddress($email, $name);

        $mail->Subject = 'Email Verification';

        // Email body (HTML)
        $mail->isHTML(true);
        $mail->Body = '<p>Hi ' . $name . ',</p>'
                    . '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>'
                    . '<p>Thank you for registering with DXCLY!</p>';

        // Plain text alternative body
        $mail->AltBody = "Hi $name,\n\nYour verification code is: $verification_code\n\nThank you for registering with DXCLY!";

        $mail->send();

        // Redirect to verification page
        header("Location: verify.php");
        exit();

    } catch (Exception $e) {
        echo "<script>alert('Verification email failed: " . htmlspecialchars($mail->ErrorInfo) . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DXCLY: Register</title>
    <link rel="stylesheet" href="css/register.css" />
    <link rel="icon" href="assets/skull.png" sizes="32x32" type="image/png" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
    />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
</head>
<body>

<?php include "templates/header.php"; ?>

<div class="content">
    <div class="register-container">
        <form class="register" method="POST" action="">
            <h2>Register</h2>
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

            <div class="details">
                <div class="personal-details">
                    <h3>Personal Details</h3>
                    <div class="input">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required />
                    </div>
                    <div class="input">
                        <label for="username">Username</label>
                        <input type="text" id="user-name" name="username" required />
                    </div>
                    <div class="input">
                        <label for="contact">Contact Number</label>
                        <input type="tel" id="contact" name="contact" required minlength="11" maxlength="11" />
                    </div>
                    <div class="input">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" required />
                    </div>
                </div>

                <div class="account-details">
                    <h3>Account Details</h3>
                    <div class="input">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required />
                    </div>
                    <div class="input">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required minlength="8" />
                    </div>
                    <div class="input">
                        <div class="input-password">
                            <label for="confirm-password">Confirm Password</label>
                            <span id="password-match"></span>
                        </div>
                        <input type="password" id="confirm-password" name="confirm-password" required minlength="8" />
                    </div>
                    <p>By creating an account you agree to our <a href="terms.php">Terms & Privacy</a></p>
                </div>
            </div>
            <button type="submit" id="register-button">Sign Up</button>
            <a href="login.php" class="login"><span>Login to an existing account</span></a>
        </form>
    </div>
</div>

<?php include "templates/footer.php"; ?>

</body>
</html>
