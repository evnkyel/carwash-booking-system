<?php
session_start();
include 'config/config.php';
include 'classes/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    $_SESSION['form_data'] = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone
    ];

    if (empty($name)) {
        $_SESSION['error_message'] = "Please enter your full name.";
        header("Location: signup.php");
        exit();
    }

    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $_SESSION['error_message'] = "Full name should only have letters and spaces.";
        header("Location: signup.php");
        exit();
    }

    if (empty($phone)) {
        $_SESSION['error_message'] = "Please enter your phone number.";
        header("Location: signup.php");
        exit();
    }

    if (!preg_match('/^[0-9]{11}$/', $phone)) {
        $_SESSION['error_message'] = "Phone number must contain exactly 11 digits.";
        header("Location: signup.php");
        exit();
    }

    $userClass = new User($conn);
    $result = $userClass->register($name, $email, $phone, $password, $confirm);

    if ($result['success']) {
        unset($_SESSION['form_data']); 
        $_SESSION['success_message'] = $result['message'];
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error_message'] = $result['message'];
        header("Location: signup.php");
        exit();
    }
}
?>
