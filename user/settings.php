<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/user/settings.css">
    <link rel="stylesheet" href="../assets/toastify.css">
    <link id="themeStylesheet" rel="stylesheet" href="">
</head>

<body>
    <div class="profile-menu-overlay"></div>

    <nav class="profile-menu">
        <ul class="profile-list">
            <li><a href="profile.php"><i class="fas fa-user-circle nav-icon"></i> My Profile</a></li>
            <li><a href="settings.php" class="active"><i class="fas fa-cog nav-icon"></i> Settings</a></li>
            <li><a href="../logout.php"><i class="fas fa-sign-out-alt nav-icon"></i> Log out</a></li>
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
                <div class="profile-icon" role="button">
                    <i class="fas fa-user-circle nav-icon fa-2x"></i>
                </div>
            </li>
        </ul>
    </header>

    <section>
        <div class="settings-container">
            <h2>Settings</h2>

            <div class="theme-toggle">
                <span>Dark Mode:</span>
                <label class="switch">
                    <input type="checkbox" id="themeSwitch">
                    <span class="slider"></span>
                </label>
            </div>

            <div class="btn-group">
                <button onclick="window.location.href='edit_profile.php'" class="btn edit-btn">
                    <i class="fas fa-edit"></i> Edit Profile
                </button>

                <button onclick="window.location.href='change_password.php'" class="btn password-btn">
                    <i class="fas fa-key"></i> Change Password
                </button>
            </div>
        </div>
    </section>

    <script src="../assets/toastify.js"></script>
    <script src="../assets/script.js"></script>
    <script src="../assets/theme.js"></script>
</body>
</html>
