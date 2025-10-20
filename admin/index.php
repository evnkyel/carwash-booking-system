<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $booking_id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action === 'confirm') {
        $stmt = $conn->prepare("UPDATE bookings SET status = 'Confirmed' WHERE booking_id = ?");
    } elseif ($action === 'cancel') {
        $stmt = $conn->prepare("UPDATE bookings SET status = 'Cancelled' WHERE booking_id = ?");
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = ?");
    }

    if (isset($stmt)) {
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php");
        exit();
    }
}

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

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/toastify.css">
    <link rel="stylesheet" href="../assets/admin.css">
</head>

<body>
    <header>
        <h2>Admin Dashboard</h2>
        <a href="../logout.php" class="logout">Logout</a>
    </header>

    <div class="dashboard">
        <h1>Manage Bookings</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Email</th>
                <th>Service</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    $formatted_date = date("l, F j, Y", strtotime($row['appointment_date']));
                    $formatted_time = date("g:i A", strtotime($row['appointment_time']));
                    ?>
                    <tr id="booking-<?= $row['booking_id'] ?>">
                        <td><?= htmlspecialchars($row['booking_id']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['service_type']) ?></td>
                        <td><?= htmlspecialchars($formatted_date) ?></td>
                        <td><?= htmlspecialchars($formatted_time) ?></td>
                        <td class="status"><?= htmlspecialchars($row['status']) ?></td>
                        <td class="actions">
                            <?php if ($row['status'] === 'Pending'): ?>
                                <a href="?action=confirm&id=<?= $row['booking_id'] ?>" class="confirm">Confirm</a>
                                <a href="#" class="cancel cancel-btn" data-id="<?= $row['booking_id'] ?>">Cancel</a>
                            <?php endif; ?>
                            <a href="#" class="delete delete-btn" data-id="<?= $row['booking_id'] ?>">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No bookings found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
    
    <script src="../assets/admin.js"></script>
    <script src="../assets/toastify.js"></script>
</body>

</html>