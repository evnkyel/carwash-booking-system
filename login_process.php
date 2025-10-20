<?php
session_start();
include 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['login_success'] = true;

            if ($user['role'] === 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: user/index.php");
            }
            exit();
        } else {
            $_SESSION['error_message'] = "Incorrect password! Please try again.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Email not found! Please check your email.";
        header("Location: login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
