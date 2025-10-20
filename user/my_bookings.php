<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT booking_id, service_type, appointment_date, appointment_time, status FROM bookings WHERE user_id = ? ORDER BY appointment_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/my_bookings.css">
    <link rel="stylesheet" href="../assets/toastify.css">
    <style>

    </style>
</head>

<body>
    <div class="profile-menu-overlay"></div>

    <nav class="profile-menu">
        <ul class="profile-list">
            <li><a href="profile.php"><i class="fas fa-user-circle nav-icon"></i> My Profile</a></li>
            <li><a href="settings.php"><i class="fas fa-cog nav-icon"></i> Settings</a></li>
            <li><a href="../logout.php"><i class="fas fa-sign-out-alt nav-icon"></i> Log out</a></li>
        </ul>
    </nav>

    <header class="header">
        <div class="logo">Car Wash</div>
        <ul class="nav-links">
            <li><a href="index.php#home" class="nav-link">Home</a></li>
            <li><a href="index.php#services" class="nav-link">Services</a></li>
            <li><a href="booking.php" class="nav-link">Book Now</a></li>
            <li><a href="my_bookings.php" class="nav-link active">My Bookings</a></li>
            <li><a href="index.php#about-us" class="nav-link">About Us</a></li>
            <li>
                <div class="profile-icon" role="button">
                    <i class="fas fa-user-circle nav-icon fa-2x"></i>
                </div>
            </li>
        </ul>
    </header>

    <div class="bookings-container">
        <h2>My Bookings</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Service Type</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                        $formatted_date = date("l, F j, Y", strtotime($row['appointment_date']));
                        $formatted_time = date("g:i A", strtotime($row['appointment_time']));
                        ?>
                        <tr id="booking-<?= $row['booking_id']; ?>">
                            <td><?= htmlspecialchars($row['service_type']); ?></td>
                            <td><?= htmlspecialchars($formatted_date); ?></td>
                            <td><?= htmlspecialchars($formatted_time); ?></td>
                            <td><span class="status <?= htmlspecialchars($row['status']); ?>"><?= htmlspecialchars($row['status']); ?></span></td>
                            <td>
                                <?php if ($row['status'] !== 'Cancelled' && $row['status'] !== 'Completed'): ?>
                                    <button class="cancel-btn" data-id="<?= $row['booking_id']; ?>">Cancel</button>
                                <?php else: ?>
                                    <span style="color:#999;">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align:center; color:#555;">No bookings found.</p>
        <?php endif; ?>

        <div style="text-align:center">
            <a href="index.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Home</a>
        </div>
    </div>

    <script src="../assets/toastify.js"></script>
    <script src="../assets/script.js"></script>
    <script src="../assets/my_bookings.js"></script>
</body>

</html>