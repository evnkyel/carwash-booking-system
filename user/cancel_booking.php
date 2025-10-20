<?php
include '../config/config.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_POST['booking_id'])) {
    echo json_encode(['success' => false]);
    exit();
}

$user_id = $_SESSION['user_id'];
$booking_id = $_POST['booking_id'];

$stmt = $conn->prepare("UPDATE bookings SET status = 'Cancelled' WHERE booking_id = ? AND user_id = ?");
$stmt->bind_param("ii", $booking_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
