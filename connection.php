<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "dxcly";

// Create the database connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check if connection failed
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
