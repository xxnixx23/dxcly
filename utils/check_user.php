<?php
session_start();

try {
    if (isset($_SESSION['id']) && $_SESSION['logged_in'] == true) {
        echo json_encode(['id' => $_SESSION['id'], "loggedIn" => "true"]);
    } else {
        echo json_encode(['loggedIn' => "false"]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e]);
}
