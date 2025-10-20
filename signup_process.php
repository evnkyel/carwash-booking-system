<?php
session_start();
include 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $_SESSION['error_message'] = "Passwords do not match!";
        header("Location: signup.php");
        exit();
    }

    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Email already exists!";
        header("Location: signup.php");
        exit();
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $hashed);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Account created successfully! You can now log in.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Something went wrong. Please try again.";
        header("Location: signup.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
