<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css" />
    <link rel="icon" href="assets/skull.png" sizes="32x32" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>DXCLY: Login</title>
    
    <!-- ✅ Add reCAPTCHA script here -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <?php include  "templates/header.php"; ?>

    <div class="content">
        <!-- Login -->
        <div class="login-container">
            <form class="login">
                <h2>Login</h2>
                <div class="input">
                    <label for="email">Email</label>
                    <input type="email" id="email" required>
                </div>
                <div class="input">
                    <div class="input-password">
                        <label for="password">Password</label>
                        <span id="forgot-password">Forget Password?</span>
                    </div>
                    <div class="password-container">
                        <input type="password" id="password" required minlength="8">
                        <span id="show-password" class="material-symbols-outlined"> visibility </span>
                    </div>
                </div>

                <!-- ✅ CAPTCHA goes here -->
    <div class="g-recaptcha" data-sitekey="6LfV5DorAAAAABN8Ud22F8L7YMUjgjye7rRYgy1j"></div>
                <button type="button" id="login-button">Sign In</button>
                <a href="register.php" class="create"><span>Create Account</span></a>
            </form>

            <!-- Verify Email -->
            <form class="verify">
                <h2>Verify Email</h2>
                <div class="input">
                    <div class="input-email">
                        <label for="email-verify">Email</label>
                        <span id="send-code">Send Code</span>
                    </div>
                    <input type="email" id="email-verify" required>
                </div>
                <div class="input">
                    <div class="input-password">
                        <label for="pin">Verification Pin</label>
                    </div>
                    <div class="password-container">
                        <input type="tel" id="pin" required minlength="6" maxlength="6" autocomplete="off">
                    </div>
                </div>
                <button type="button" id="verify-button">Verify</button>
                <span class="cancel">Cancel</span>
            </form>
        </div>
    </div>

    <?php include  "templates/footer.php"; ?>

    <script src="js/login.js"></script>
</body>

</html>