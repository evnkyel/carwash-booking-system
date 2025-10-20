<?php
session_start();
include 'config/config.php';
include 'classes/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    $_SESSION['login_form_data'] = ['email' => $email];

    $userClass = new User($conn);
    $user = $userClass->login($email, $password);

    if ($user) {
        unset($_SESSION['login_form_data']);

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['login_success'] = true;

        if ($remember) {
            setcookie("remember_email", $email, time() + (7 * 24 * 60 * 60), "/");
        } else {
            setcookie("remember_email", "", time() - 3600, "/");
        }

        if ($user['role'] === 'admin') {
            header("Location: admin/index.php");
        } else {
            header("Location: user/index.php");
        }
        exit();
    } else {
        $_SESSION['error_message'] = "Invalid email or password.";
        header("Location: login.php");
        exit();
    }
}
