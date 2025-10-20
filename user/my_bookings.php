<?php
session_start();
include '../config/config.php';
include '../classes/Booking.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$booking = new Booking($conn);
$bookings = $booking->getBookingsByUser($user_id);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/toastify.css">
    <link rel="stylesheet" href="../assets/user/my_bookingss.css">
    <link id="themeStylesheet" rel="stylesheet" href="">

    <style>
        body {
            background: linear-gradient(to bottom, #B2EBF2, #E0F7FA);
            overflow: hidden;
        }
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
            <li><a href="index.php#about" class="nav-link">About Us</a></li>
            <li>
                <div class="profile-icon" role="button">
                    <i class="fas fa-user-circle nav-icon fa-2x"></i>
                </div>
            </li>
        </ul>
    </header>

    <section>
        <div class="bookings-container">
            <h2>My Bookings</h2>

            <?php if (!empty($bookings)): ?>
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
                        <?php foreach ($bookings as $row): ?>
                            <?php
                            $formatted_date = date("l, F j, Y", strtotime($row['appointment_date']));
                            $formatted_time = date("g:i A", strtotime($row['appointment_time']));
                            ?>
                            <tr id="booking-<?= $row['booking_id'] ?>">
                                <td><?= htmlspecialchars($row['service_type']) ?></td>
                                <td><?= htmlspecialchars($formatted_date) ?></td>
                                <td><?= htmlspecialchars($formatted_time) ?></td>
                                <td>
                                    <span class="status <?= htmlspecialchars($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></span>
                                </td>
                                <?php if ($row['status'] !== 'Cancelled' && $row['status'] !== 'Completed'): ?>
                                    <td><button class="cancel-btn" data-id="<?= $row['booking_id'] ?>">Cancel</button></td>
                                <?php else: ?>
                                    <td>-</td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align:center; color:#555;">No bookings found.</p>
            <?php endif; ?>

            <div style="text-align:center">
                <a href="index.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Home</a>
            </div>
        </div>
    </section>

    <script src="../assets/toastify.js"></script>
    <script src="../assets/script.js"></script>
    <script src="../assets/user/my_bookings.js"></script>
    <script src="../assets/theme.js"></script>
</body>

</html>