<?php
session_start();
include_once 'config/config.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Please log in First.";
    header("Location: login.php");
    exit();
}
?>