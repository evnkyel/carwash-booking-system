<?php
class Booking
{
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($user_id, $service_type, $appointment_date, $appointment_time) {
        $sql = "INSERT INTO bookings (user_id, service_type, appointment_date, appointment_time)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isss", $user_id, $service_type, $appointment_date, $appointment_time);
        return $stmt->execute();
    }

    public function cancel($booking_id, $user_id) {
        $sql = "UPDATE bookings SET status = 'Cancelled' WHERE booking_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $booking_id, $user_id);
        return $stmt->execute();
    }

    public function getBookingsByUser($user_id) {
        $stmt = $this->conn->prepare("SELECT booking_id, service_type, appointment_date, appointment_time, status 
                                    FROM bookings 
                                    WHERE user_id = ? 
                                    ORDER BY appointment_date DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllBookings() {
        $sql = "SELECT 
                    b.booking_id, 
                    b.service_type, 
                    b.appointment_date, 
                    b.appointment_time, 
                    b.status, 
                    u.name, 
                    u.email
                FROM bookings AS b
                JOIN users AS u ON b.user_id = u.user_id
                ORDER BY b.booking_id DESC";
        return $this->conn->query($sql);
    }

    public function updateStatus($booking_id, $status) {
    if ($status === 'Completed') {
        $stmt = $this->conn->prepare("UPDATE bookings SET status = ?, completed_at = NOW() WHERE booking_id = ?");
        $stmt->bind_param("si", $status, $booking_id);
    } else {
        $stmt = $this->conn->prepare("UPDATE bookings SET status = ? WHERE booking_id = ?");
        $stmt->bind_param("si", $status, $booking_id);
    }
    return $stmt->execute();
    }

    public function deleteBooking($booking_id) {
        $stmt = $this->conn->prepare("DELETE FROM bookings WHERE booking_id = ?");
        $stmt->bind_param("i", $booking_id);
        return $stmt->execute();
    }

    public function countAll() {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM bookings");
        return $result->fetch_assoc()['total'];
    }

    public function countByStatus($status) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM bookings WHERE status = ?");
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'];
    }
}
