<?php
session_start();
include '../config/config.php';
include '../classes/Booking.php';

header('Content-Type: application/json'); 

if (!isset($_SESSION['user_id']) || !isset($_POST['booking_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$user_id = $_SESSION['user_id'];
$booking_id = $_POST['booking_id'];

$booking = new Booking($conn);

if ($booking->cancel($booking_id, $user_id)) {
    echo json_encode(['success' => true, 'message' => 'Booking cancelled successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to cancel booking']);
}
?>