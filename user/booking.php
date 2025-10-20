<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "Please log in before booking a service.";
    header("Location: login.php");
    exit;
}

if (isset($_SESSION['error_message'])) {
    echo "
    <script>
    window.addEventListener('DOMContentLoaded', () => {
        Toastify({
            text: '" . addslashes($_SESSION['error_message']) . "',
            duration: 3000,
            gravity: 'top',
            position: 'center',
            close: true,
            style: {
                background: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                borderRadius: '10px',
                color: '#fff',
                textAlign: 'center',
                fontSize: '16px'
            }
        }).showToast();
    });
    </script>
    ";
    unset($_SESSION['error_message']);
}

if (isset($_SESSION['success_message'])) {
    echo "
    <script>
    window.addEventListener('DOMContentLoaded', () => {
        Toastify({
            text: '" . addslashes($_SESSION['success_message']) . "',
            duration: 3000,
            gravity: 'top',
            position: 'center',
            close: true,
            style: {
                background: 'linear-gradient(to right, #00b09b, #96c93d)',
                borderRadius: '12px',
                fontSize: '16px',
                color: '#fff',
                textAlign: 'center'
            }
        }).showToast();
    });
    </script>
    ";
    unset($_SESSION['success_message']);
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
    <link rel="stylesheet" href="../assets/toastify.css">
    <link rel="stylesheet" href="../assets/user/booking.css">
    <link id="themeStylesheet" rel="stylesheet" href="">
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
                <div class="form-group short">
                    <label for="booking-date">Select Date</label>
                    <input type="date" id="booking-date" name="appointment_date" required>
                </div>

                <div class="form-group short">
                    <label for="booking-time">Select Time</label>
                    <input type="time" id="booking-time" name="appointment_time" min="08:00" max="15:59" required>
                </div>

                <div class="form-group full">
                    <label class="serv-cho">Choose Your Service Package</label>
                    <div class="service-options">
                        <?php
                        $result = $conn->query("SELECT * FROM services ORDER BY id ASC");
                        while ($row = $result->fetch_assoc()):
                            $id = strtolower(str_replace(' ', '-', $row['service_name']));
                        ?>
                            <div class="service-option">
                                <input type="radio" name="service_type" value="<?= htmlspecialchars($row['service_name']) ?>" id="<?= $id ?>" required>
                                <div class="service-info">
                                    <div class="radio-custom"></div>
                                    <label for="<?= $id ?>" class="service-name"><?= htmlspecialchars($row['service_name']) ?></label>
                                </div>
                                <span class="service-price2">₱<?= number_format($row['price'], 2) ?></span>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="form-group full">
                    <button type="submit" class="book-btn">Book Now</button>
                </div>
            </form>
        </div>
    </section>

    <script src="../assets/script.js"></script>
    <script src="../assets/toastify.js"></script>
    <script src="../assets/theme.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const dateInput = document.getElementById("booking-date");
            const timeInput = document.getElementById("booking-time");

            const today = new Date();
            const year = today.getFullYear();

            const minDate = today;
            const maxDate = new Date(year, 11, 31); 

            const toInputDate = (date) => {
                const m = (date.getMonth() + 1).toString().padStart(2, '0');
                const d = date.getDate().toString().padStart(2, '0');
                return `${date.getFullYear()}-${m}-${d}`;
            };

            dateInput.min = toInputDate(minDate);
            dateInput.max = toInputDate(maxDate);

            timeInput.min = "08:00";
            timeInput.max = "15:59";

            timeInput.addEventListener("change", () => {
                const [hour, minute] = timeInput.value.split(":").map(Number);
                if (hour < 8 || hour >= 16) {
                    Toastify({
                        text: "Bookings are only allowed from 8:00 AM to 4:00 PM.",
                        duration: 3000,
                        gravity: "top",
                        position: "center",
                        close: true,
                        style: {
                            background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                            borderRadius: "10px",
                            color: "#fff",
                            textAlign: "center"
                        }
                    }).showToast();
                    timeInput.value = "";
                }
            });
        });
    </script>
</body>

</html>
