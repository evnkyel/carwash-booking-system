<?php
session_start();
include_once 'config/config.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Please log in before booking a service.";
    header("Location: /login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];
    $service_type = trim($_POST['service_type']);
    $appointment_date = trim($_POST['appointment_date']);
    $appointment_time = trim($_POST['appointment_time']);

    if (empty($service_type) || empty($appointment_date) || empty($appointment_time)) {
        $_SESSION['error_message'] = "Please fill in all required fields.";
        header("Location: booking.php");
        exit;
    }

    $sql = "INSERT INTO bookings (user_id, service_type, appointment_date, appointment_time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $_SESSION['error_message'] = "Database error: " . $conn->error;
        header("Location: booking.php");
        exit;
    }

    $stmt->bind_param("isss", $user_id, $service_type, $appointment_date, $appointment_time);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Booking successful!";
    } else {
        $_SESSION['error_message'] = "Something went wrong while saving your booking.";
    }

    $stmt->close();
    $conn->close();

    header("Location: booking.php");
    exit;
}
