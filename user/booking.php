<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Please log in before booking a service.";
    header("Location: login.php");
    exit;
}

if (isset($_SESSION['success_message']) || isset($_SESSION['error_message'])) {
    echo "
    <script>
    window.addEventListener('DOMContentLoaded', () => {
        Toastify({
            text: '" . addslashes($_SESSION['success_message'] ?? $_SESSION['error_message']) . "',
            duration: 3000,
            gravity: 'top',
            position: 'center',
            backgroundColor: '" . (isset($_SESSION['success_message']) ? "#4CAF50" : "#F44336") . "',
        }).showToast();
    });
    </script>
    ";
    unset($_SESSION['success_message']);
    unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Now</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel='stylesheet' href='../assets/toastify.css'>
    <link rel="stylesheet" href="../assets/booking.css">
</head>

<body>
    <div class="profile-menu-overlay"></div>

    <nav class="profile-menu">
        <ul class="profile-list">
            <li><a href="profile.php"><i class="fas fa-user-circle nav-icon"></i> My Profile</a></li>
            <li><a href="settings.php"><i class="fas fa-cog nav-icon"></i> Settings</a></li>
            <li><a href="../logout.php"><i class="fas fa-sign-out-alt nav-icon"></i> Log Out</a></li>
        </ul>
    </nav>

    <header class="header">
        <div class="logo">Car Wash</div>
        <ul class="nav-links">
            <li><a href="index.php#home" class="nav-link">Home</a></li>
            <li><a href="index.php#services" class="nav-link">Services</a></li>
            <li><a href="booking.php" class="nav-link active">Book Now</a></li>
            <li><a href="my_bookings.php" class="nav-link">My Bookings</a></li>
            <li><a href="index.php#about" class="nav-link">About Us</a></li>
            <li>
                <div class="profile-icon" role="button" aria-haspopup="true" aria-expanded="false" tabindex="0">
                    <i class="fas fa-user-circle nav-icon fa-2x" aria-hidden="true"></i>
                </div>
            </li>
        </ul>
    </header>

    <section class="booking-section">
        <div class="booking-container">
            <h2>Book Your Car Wash Appointment</h2>

            <form id="bookingForm" action="booking_process.php" method="POST">
                <div class="form-group">
                    <label for="booking-date">Select Date</label>
                    <input type="date" id="booking-date" name="appointment_date" required>
                </div>

                <div class="form-group">
                    <label for="booking-time">Select Time</label>
                    <input type="time" id="booking-time" name="appointment_time" required>
                </div>

                <div class="form-group full">
                    <label class="serv-cho">Choose Your Service Package</label>
                    <div class="service-options">

                        <div class="service-option">
                            <input type="radio" name="service_type" value="Basic Package" id="basic" required>
                            <div class="service-info">
                                <div class="radio-custom"></div>
                                <label for="basic" class="service-name">Basic Package</label>
                            </div>
                            <span class="service-price">₱250</span>
                        </div>

                        <div class="service-option">
                            <input type="radio" name="service_type" value="Standard Package" id="standard">
                            <div class="service-info">
                                <div class="radio-custom"></div>
                                <label for="standard" class="service-name">Standard Package</label>
                            </div>
                            <span class="service-price">₱500</span>
                        </div>

                        <div class="service-option">
                            <input type="radio" name="service_type" value="Premium Package" id="premium">
                            <div class="service-info">
                                <div class="radio-custom"></div>
                                <label for="premium" class="service-name">Premium Package</label>
                            </div>
                            <span class="service-price">₱1,200</span>
                        </div>

                        <div class="service-option" data-service="ultimate">
                            <input type="radio" name="service_type" value="Ultimate Package" id="ultimate">
                            <div class="service-info">
                                <div class="radio-custom"></div>
                                <label for="ultimate" class="service-name">Ultimate Package</label>
                            </div>
                            <span class="service-price">₱2,500</span>
                        </div>
                    </div>
                </div>
                <div class="form-group full">
                    <button type="submit" class="book-btn">Book Now</button>
                </div>
            </form>
        </div>
    </section>
    <script src="../assets/script.js"></script>
    <script src='../assets/toastify.js'></script>
</body>

</html>