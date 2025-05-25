<?php
require_once 'api/db.php'; // Adjust the path if needed

$stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/create-product.css" />
    <link rel="icon" href="assets/skull.png" sizes="32x32" type="image/png" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css"
      integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"
      integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>

    <div class="create-container">
        <h2>Add Product</h2>
        <form class="create">
            <div class="left">
                <img id="product-preview" src="assets/default-product.png" />
                <label for="product-input">Choose File</label>
                <input type="file" id="product-input" accept="image/*" />
            </div>
            <div class="right">
                <div class="row">
                    <div class="input">
                        <label for="name">Name</label>
                        <input type="text" id="name" required />
                    </div>
                    <div class="input">
                        <label for="type">Type</label>
                        <select name="type" id="type">
                            <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat['name']); ?>">
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input">
                        <label for="price">Price</label>
                        <input type="tel" id="price" required />
                    </div>
                    <div class="input">
                        <label for="quantity">Quantity</label>
                        <input type="tel" id="quantity" required />
                    </div>
                </div>
                <div class="row">
                    <div class="input">
                        <label for="description">Description</label>
                        <textarea id="description" required></textarea>
                    </div>
                </div>
                <button type="button" id="create-button">Create</button>
            </div>
        </form>
    </div>

    <script src="js/create-product.js"></script>
</body>

</html>
