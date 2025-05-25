<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/product-admin.css" />
    <link rel="icon" href="assets/skull.png" sizes="32x32" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/simplePagination.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.min.js"></script>

    <div class="products-container">
        <h2>Products</h2>
        <div class="controls">
            <input type="text" id="search" placeholder="Search" onkeyup="displayProducts()">
            <div class="left">
                <button type="button" id="delete-button" onclick="deleteProducts()">Delete Selected Products</button>
                <div class="filter-container">
                    <label for="filter">Filter by Type</label>
                    <select id="filter" onchange="displayProducts()">
                        <option value="">All</option>
                        <option value="jackets">Jackets</option>
                        <option value="hoodies">Hoodies</option>
                        <option value="vest">Vest</option>
                        <option value="pants">Pants</option>
                        <option value="shirts">Shirts</option>
                        <option value="cloaks">Cloaks</option>
                        <option value="shorts">Shorts</option>
                        <option value="footwear">Footwear</option>
                        <option value="hats">Hats</option>
                        <option value="masks">Masks</option>
                        <option value="belts">Belts</option>
                        <option value="gloves">Gloves</option>
                        <option value="backpacks">Backpacks</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="products-table">
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="products-body"></tbody>
            </table>

            <div id="pagination"></div>
        </div>
    </div>

    <script src="js/products-admin.js"></script>
</body>

</html>