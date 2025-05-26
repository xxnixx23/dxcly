<!-- Header -->
<html>

<head>
    <link rel="stylesheet" href="css/header-admin.css">
</head>

<body>

    <div class="header">
        <div class="left">
            <span class="logo"><a href="index.php">DXCLY</a></span>
        </div>
        <div class="center">
            <span><a href="dashboard.php">Dashboard</a>
                <hr />
            </span>
            <span>
                <a href="dashboard.php?page=users">Users</a>
                <hr />
            </span>
            <span class="dropdown-container">
                Products
                <hr />
                <div class="dropdown">
                    <span><a href="dashboard.php?page=create-product">Add New Product</a></span>
                    <span><a href="dashboard.php?page=view-products">View Products</a></span>
                       <span><a href="dashboard.php?page=manage-categories">Manage Categories</a></span>

                </div>
            </span>
            <span>
                <span><a href="dashboard.php?page=orders">Sales / Orders</a></span>
                <hr />
            </span>
            <span>
                <span><a href="dashboard.php?page=logs">Logs</a></span>
                <hr />
            </span>
        </div>

        <div class="right">
            <span id="logout-button">Logout</span>
            <span class="material-symbols-outlined">
                logout
            </span>
        </div>
    </div>

    <script src="js/header-admin.js"></script>
</body>

</html>