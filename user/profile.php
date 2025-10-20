<?php
session_start();
include '../config/config.php';
include '../classes/User.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$userClass = new User($conn);
$user = $userClass->getUserById($user_id);

if (!$user) {
    die("User not found!");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/toastify.css">
    <link rel="stylesheet" href="../assets/user/profile.css">
    <link id="themeStylesheet" rel="stylesheet" href="">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom, #B2EBF2, #E0F7FA);
            height: 100vh;
        }
    </style>
</head>

<body>
    <div class="profile-menu-overlay"></div>

    <nav class="profile-menu">
        <ul class="profile-list">
            <li><a href="profile.php" class="active"><i class="fas fa-user-circle nav-icon"></i> My Profile</a></li>
            <li><a href="settings.php"><i class="fas fa-cog nav-icon"></i> Settings</a></li>
            <li><a href="../logout.php" id="logout-btn"><i class="fas fa-sign-out-alt nav-icon"></i> Logout</a></li>
        </ul>
    </nav>

    <header class="header">
        <div class="logo">Car Wash</div>
        <ul class="nav-links">
            <li><a href="index.php#home" class="nav-link">Home</a></li>
            <li><a href="index.php#services" class="nav-link">Services</a></li>
            <li><a href="booking.php" class="nav-link">Book Now</a></li>
            <li><a href="my_bookings.php" class="nav-link">My Bookings</a></li>
            <li><a href="index.php#about" class="nav-link">About Us</a></li>
            <li>
                <div class="profile-icon" role="button" aria-haspopup="true" aria-expanded="false" tabindex="0">
                    <i class="fas fa-user-circle nav-icon fa-2x" aria-hidden="true"></i>
                </div>
            </li>
        </ul>
    </header>

    <section class="profile-sect">
        <div class="profile-card">
            <div class="prof-icon"><i class="fas fa-user-circle nav-icon fa-6x"></i></div>
            <h2><?= htmlspecialchars($user['name']); ?></h2>
            <div class="info">
                <p><span>Email:</span> <?= htmlspecialchars($user['email']); ?></p>
                <p><span>Phone:</span> <?= htmlspecialchars($user['phone']); ?></p>
            </div>

            <div class="btn-container">
                <button class="btn" onclick="window.location.href='settings.php'">
                    <i class="fas fa-cog"></i> Manage Account
                </button>

            </div>
        </div>
    </section>

    <script src="../assets/toastify.js"></script>
    <script src="../assets/script.js"></script>
    <script src="../assets/theme.js"></script>


    <?php if (isset($_SESSION['profile_updated']) && $_SESSION['profile_updated'] === true): ?>
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                Toastify({
                    text: 'Profile updated successfully!',
                    duration: 3000,
                    gravity: 'top',
                    position: 'center',
                    close: true,
                    style: {
                        background: 'linear-gradient(to right, #00b09b, #96c93d)',
                        borderRadius: '12px',
                        fontSize: '16px',
                        textAlign: 'center'
                    }
                }).showToast();
            });
        </script>
        <?php unset($_SESSION['profile_updated']); ?>
    <?php endif; ?>
</body>

</html>