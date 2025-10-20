<?php
session_start();
include_once '../config/config.php';
include_once '../classes/Booking.php';

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

    $booking = new Booking($conn);

    if ($booking->create($user_id, $service_type, $appointment_date, $appointment_time)) {
        $_SESSION['success_message'] = "Booking successful!";
    } else {
        $_SESSION['error_message'] = "Something went wrong while saving your booking.";
    }

    header("Location: booking.php");
    exit;
}