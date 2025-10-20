<?php
session_start();
include_once 'config/config.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Please log in before booking a service.";
    header("Location: login.php");
    exit;
}
