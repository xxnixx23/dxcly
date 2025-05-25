<?php
session_start();

if (!isset($_SESSION['forgot_password_code']) || !isset($_SESSION['reset_email'])) {
    echo "<script>alert('Session expired or invalid access.'); window.location.href='forgot_password.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['code'])) {
    $input_code = trim($_POST['code']);
    $correct_code = $_SESSION['forgot_password_code'];

    if ($input_code === $correct_code) {
        // Verified successfully
        header("Location: reset_pass.php");
        exit();
    } else {
        $error = "Incorrect verification code.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Code - DXCLY</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>

<?php include "templates/header.php"; ?>

<div class="content">
    <div class="register-container">
        <form method="POST" action="">
            <h2>Enter Verification Code</h2>
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <div class="input">
                <label for="code">Verification Code</label>
                <input type="text" id="code" name="code" required minlength="6" maxlength="6">
            </div>
            <button type="submit">Verify</button>
        </form>
    </div>
</div>

<?php include "templates/footer.php"; ?>

</body>
</html>
