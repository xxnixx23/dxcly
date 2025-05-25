<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/logs.css" />
    <link rel="icon" href="assets/skull.png" sizes="32x32" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/simplePagination.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.min.js"></script>


    <div class="logs-container">
        <h2>Logs</h2>
        <div class="controls">
            <input type="text" id="search" placeholder="Search" onkeyup="displayLogs()">
            <div class="filters">
                <button id="download-button" onclick="downloadPDF()">
                    Download
                    <span class="material-symbols-outlined">
                        download
                    </span>
                </button>
                <div class="date-container">
                    <label for="date">Filter By Date</label>
                    <input type="month" name="date" id="date" onchange="displayLogs()">
                </div>
                <div class="filter-container">
                    <label for="filter">Filter by Action</label>
                    <select id="filter" onchange="displayLogs()">
                        <option value="">All</option>
                        <option value="Login">Login</option>
                        <option value="Log Out">Log Out</option>
                        <option value="Change Password">Change Password</option>
                        <option value="Update Profile">Update Profile</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="table-container">
            <table id="logs-table">
                <thead>
                    <tr>
                        <th>Log ID</th>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Action</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody id="logs-body"></tbody>
            </table>

            <div id="pagination"></div>
        </div>
    </div>

    <script src="js/logs.js"></script>
</body>

</html>