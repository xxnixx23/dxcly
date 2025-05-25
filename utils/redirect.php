<?php

session_start();

if (isset($_SESSION['logged_in'])) {
    if ($_SESSION['logged_in'] == true) {
        header('Location: ../account.php');
    } else {
        header('Location: ../login.php');
    }
} else {
    header('Location: ../login.php');
}
