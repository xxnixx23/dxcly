<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/account.css" />
    <link rel="icon" href="assets/skull.png" sizes="32x32" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>DXCLY: Account</title>
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment-with-locales.min.js" integrity="sha512-4F1cxYdMiAW98oomSLaygEwmCnIP38pb4Kx70yQYqRwLVCs3DbRumfBq82T08g/4LJ/smbFGFpmeFlQgoDccgg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php
    session_start();
    if (isset($_SESSION['logged_in'])) {
        if (!$_SESSION['logged_in']) {
            header("Location: login.php");
        }
    }

    //blocks buyer from accessing the admin dashboard page
    if (isset($_SESSION['account_type'])) {
        if ($_SESSION['account_type'] == "admin") {
            header("Location: dashboard.php");
        }
    }
    ?>

    <?php include  "templates/header.php"; ?>

    <div class="content">
        <!-- Account -->
        <div class="account-container">
            <div class="account">
                <div class="top">
                    <h2>
                        My Account
                    </h2>
                    <button id="logout-button">Sign Out</button>
                </div>
                <div class="bottom">
                    <div class="order-details">
                        <h2>
                            Your Orders
                        </h2>
                        <select id="filter" onchange="displayOrders()">
                            <option value="">All</option>
                            <option value="To Pay">To Pay</option>
                            <option value="To Receive">To Receive</option>
                            <option value="Completed">Completed</option>
                        </select>
                        <div class="orders"></div>
                    </div>
                    <div class="account-details">
                        <h2>Account Details</h2>
                        <div class="center">
                            <form class="details">
                                <div class="detail">
                                    <span class="label">Name</span>
                                    <input type=text" id="name" required />
                                </div>
                                <div class="detail">
                                    <span class="label">Username</span>
                                    <input type="text" id="username" required />
                                </div>
                                <div class="detail">
                                    <span class="label">Email</span>
                                    <input type="email" id="email" required />
                                </div>
                                <div class="detail">
                                    <span class="label">Contact Number</span>
                                    <input type="tel" id="contact" required minlength="11" maxlength="11" />
                                </div>
                                <div class="detail">
                                    <span class="label">Address</span>
                                    <input type="address" id="address" required />
                                </div>
                                <div class="method-container">
                                    <span class="label">Payment Method</span>
                                    <div class="methods">
                                        <img src="assets/gcash.png" alt="" id="method-preview">
                                        <select id="method">
                                            </option>
                                            <option value="GCash">GCash</option>
                                            <option value="Maya">Maya</option>
                                            <option value="Card">Card</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <button type="button" id="update-btn">Save</button>
                                    <span id="change-password">Change Password</span>
                                </div>
                            </form>
                            <div class="display-picture">
                                <img id="pfp-preview">
                                <label for="pfp-input">Choose File</label>
                                <input type="file" id="pfp-input" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pay Modal -->
    <div class="payment-modal">
        <div class="modal-container">
            <span id="close-btn" class="material-symbols-outlined"> close </span>
            <img src="assets/qr.png" alt="">
            <span>Scan QR Code to Pay</span>
        </div>
    </div>

    </div>
    <br>
    <br>
 <br>
    <br>
    <?php include  "templates/footer.php"; ?>

    <script src="js/account.js"></script>
</body>

</html>