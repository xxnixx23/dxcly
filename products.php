<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/products.css" />
    <link rel="icon" href="assets/skull.png" sizes="32x32" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/simplePagination.min.css">
    <title>DXCLY: Techwear Collection</title>
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <?php include  "templates/header.php"; ?>

    <div class="content">
        <!-- Products -->
        <div class="products-container">
            <div class="products">
                <h2 id="title"></h2>
                <p id="description"></p>
                <div class="options">
                    <div class="search-container">
                        <input type="text" class="search">
                        <button class="search-btn">
                            <span class="material-symbols-outlined"> search </span>
                            Search
                        </button>
                    </div>
                    <div class="sort-container">
                        <span>Sort by price: </span>
                        <select class="sort">
                            <option value="None" selected>None</option>
                            <option value="Ascending">Low - High</option>
                            <option value="Descending">High - Low</option>
                        </select>
                    </div>
                </div>
                <hr>
                <h4 class="number-of-products">
                </h4>
                <div class="products-collection">

                </div>
                <div id="pagination"></div>
            </div>
        </div>
    </div>

    <?php include  "templates/footer.php"; ?>

    <script src="js/products.js"></script>
</body>

</html>