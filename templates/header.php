<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DXCLY</title>
    <link rel="stylesheet" href="css/header.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body>

    <!-- Desktop Header -->
    <div class="header">
        <div class="top">
            <span class="text-email">Any questions? info@dxcly.com</span>
            <span class="text-shipping">FREE SHIPPING</span>
        </div>
        <div class="bottom">
            <div class="left">
                <span class="logo"><a href="index.php">DXCLY</a></span>
            </div>
            <div class="center">
                <span><a href="index.php">Home</a><hr /></span>
                <span><a href="products.php">Techwear</a><hr /></span>

                <span class="dropdown-container">
                    Clothes
                    <hr />
                    <div class="dropdown">
                        <span><a href="products.php?type=Jackets">Jackets</a></span>
                        <span><a href="products.php?type=Hoodies">Hoodies</a></span>
                        <span><a href="products.php?type=Vest">Vest</a></span>
                        <span><a href="products.php?type=Pants">Pants</a></span>
                        <span><a href="products.php?type=Shirts">Shirts</a></span>
                        <span><a href="products.php?type=Cloaks">Cloaks</a></span>
                        <span><a href="products.php?type=Shorts">Shorts</a></span>
                    </div>
                </span>

                <span><a href="products.php?type=Footwear">Footwear</a><hr /></span>

                <span class="dropdown-container">
                    Accessories
                    <hr />
                    <div class="dropdown">
                        <span><a href="products.php?type=Hats">Hats</a></span>
                        <span><a href="products.php?type=Masks">Masks</a></span>
                        <span><a href="products.php?type=Belts">Belts</a></span>
                        <span><a href="products.php?type=Gloves">Gloves</a></span>
                        <span><a href="products.php?type=Backpacks">Backpacks</a></span>
                    </div>
                </span>

                <span class="dropdown-container">
                    Collections
                    <hr />
                    <div class="dropdown">
                        <?php
                        $stmt = $pdo->query('SELECT name FROM categories ORDER BY name ASC');
                        while ($row = $stmt->fetch()) {
                            echo '<span><a href="products.php?type=' . urlencode($row['name']) . '">' . htmlspecialchars($row['name']) . '</a></span>';
                        }
                        ?>
                    </div>
                </span>
            </div>

            <div class="right">
                <span id="cart-btn" class="material-symbols-outlined">shopping_bag</span>
                <a class="pfp" href="utils/redirect.php">
                    <img id="profile-picture" src="assets/default-pfp.png" alt="">
                    <span id="username">Username</span>
                </a>
            </div>

            <!-- Cart -->
            <div class="cart-container">
                <div class="cart-view">
                    <div class="cart-top">
                        <h2>Cart</h2>
                        <span id="close-btn" class="material-symbols-outlined">close</span>
                    </div>
                    <hr>
                    <div class="carts"></div>
                    <hr>
                    <div class="cart-bottom">
                        <div class="total-container">
                            <span>SubTotal</span>
                            <span id="total">₱0.00</span>
                        </div>
                        <button id="checkout-btn">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Header -->
    <div class="header-mobile">
        <span class="logo"><a href="index.php">DXCLY</a></span>
        <span class="material-symbols-outlined" id="menu-button">menu</span>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu">
        <span id="close-menu" class="material-symbols-outlined">close</span>
        <span><a href="index.php">Home</a></span>
        <span><a href="products.php">Techwear</a></span>

        <div class="dropdown-mobile">
            <div class="title">
                <span>Clothes</span>
                <span class="material-symbols-outlined arrow">keyboard_arrow_right</span>
            </div>
            <div class="items">
                <span><a href="products.php?type=Jackets">Jackets</a></span>
                <span><a href="products.php?type=Hoodies">Hoodies</a></span>
                <span><a href="products.php?type=Vest">Vest</a></span>
                <span><a href="products.php?type=Pants">Pants</a></span>
                <span><a href="products.php?type=Shirts">Shirts</a></span>
                <span><a href="products.php?type=Cloaks">Cloaks</a></span>
                <span><a href="products.php?type=Shorts">Shorts</a></span>
            </div>
        </div>

        <span><a href="products.php?type=Footwear">Footwear</a></span>

        <div class="dropdown-mobile">
            <div class="title">
                <span>Accessories</span>
                <span class="material-symbols-outlined arrow">keyboard_arrow_right</span>
            </div>
            <div class="items">
                <span><a href="products.php?type=Hats">Hats</a></span>
                <span><a href="products.php?type=Masks">Masks</a></span>
                <span><a href="products.php?type=Belts">Belts</a></span>
                <span><a href="products.php?type=Gloves">Gloves</a></span>
                <span><a href="products.php?type=Backpacks">Backpacks</a></span>
            </div>
        </div>

        <div class="dropdown-mobile">
            <div class="title">
                <span>Collections</span>
                <span class="material-symbols-outlined arrow">keyboard_arrow_right</span>
            </div>
            <div class="items">
                <?php
                $stmt = $pdo->query('SELECT name FROM categories ORDER BY name ASC');
                while ($row = $stmt->fetch()) {
                    echo '<span><a href="products.php?type=' . urlencode($row['name']) . '">' . htmlspecialchars($row['name']) . '</a></span>';
                }
                ?>
            </div>
        </div>
    </div>

    <script src="js/header.js"></script>
</body>

</html>
