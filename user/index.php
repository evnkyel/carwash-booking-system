<?php
session_start();

if (isset($_SESSION['login_success']) && $_SESSION['login_success'] === true) {
    echo "
    <script>
    window.addEventListener('DOMContentLoaded', () => {
        Toastify({
            text: 'Welcome back, " . $_SESSION['name'] . "!',
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
    ";
    unset($_SESSION['login_success']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Wash Booking System</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel='stylesheet' href='../assets/toastify.css'>
    <link rel="stylesheet" href="../assets/about.css">

    <style>
        footer {
            background: linear-gradient(to bottom, #E0F7FA, #B2EBF2);
            text-align: center;
            color: #4d4d4d;
            font-size: 16px;
            padding: 20px;
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
            <li><a href="#home" class="nav-link active">Home</a></li>
            <li><a href="#services" class="nav-link">Services</a></li>
            <li><a href="booking.php" class="nav-link">Book Now</a></li>
            <li><a href="my_bookings.php" class="nav-link">My Bookings</a></li>
            <li><a href="#about" class="nav-link">About Us</a></li>
            <li>
                <div class="profile-icon" role="button" aria-haspopup="true" aria-expanded="false" tabindex="0">
                    <i class="fas fa-user-circle nav-icon fa-2x" aria-hidden="true"></i>
                </div>
            </li>
        </ul>
    </header>

    <section class="hero-section" id="home">
        <div class="hero-content">
            <h1 class="hero-title">Book Your Car Wash Today!</h1>
            <p class="hero-description">
                Welcome to our Online Car Wash & Detailing Service! Book your wash anytime,
                anywhere with just a few clicks. Whether it's a quick clean or premium detailing, we make it easy, fast, and hassle-free.
            </p>
            <a href="booking.php"><button class="book-btn">Book Now</button></a>
        </div>
    </section>

    <section class="features">
        <div class="feature-card">
            <div class="feature-icon">📅</div>
            <div class="feature-title">Easy Online</div>
            <div class="feature-subtitle">Booking</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🕐</div>
            <div class="feature-title">Real-Time</div>
            <div class="feature-subtitle">Scheduling</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">✉️</div>
            <div class="feature-title">SMS Email</div>
            <div class="feature-subtitle">Confirmation</div>
        </div>
        <div class="feature-card">
            <div class="feature-icon">💲</div>
            <div class="feature-title">Affordable</div>
            <div class="feature-subtitle">Pricing</div>
        </div>
    </section>

    <section class="services-section" id="services">
        <h2 class="service-title">Our Services</h2>
        <div class="service-list">
            <div class="service-card">
                <div class="service-icon-container">
                    <div class="service-icon"><img src="../assets/images/serv1.png" alt="Basic Package"></div>
                </div>
                <div class="service-content">
                    <h3 class="service-name">Basic Package</h3>
                    <p class="service-price">₱250</p>
                    <ul class="serv-list">
                        <li>Exterior Wash</li>
                        <li>Quick Interior Vacuum</li>
                        <li>Tire Shine</li>
                    </ul>
                    <span class="best"><b>Best For:</b> Fast & affordable clean.</span>
                </div>
            </div>
            <div class="service-card">
                <div class="service-icon-container">
                    <div class="service-icon"><img src="../assets/images/serv2.png" alt="Standard Package"></div>
                </div>
                <div class="service-content">
                    <h3 class="service-name">Standard Package</h3>
                    <p class="service-price">₱500</p>
                    <ul class="serv-list">
                        <li>Exterior Wash and Wax</li>
                        <li>Interior Vacuum (seats, carpets, mats)</li>
                        <li>Dashboard & Windows Cleaning</li>
                        <li>Tire Shine</li>
                    </ul>
                    <span class="best"><b>Best For:</b> Regular maintenance cleaning.</span>
                </div>
            </div>
            <div class="service-card">
                <div class="service-icon-container">
                    <div class="service-icon"><img src="../assets/images/serv3.png" alt="Premium Package"></div>
                </div>
                <div class="service-content">
                    <h3 class="service-name">Premium Package</h3>
                    <p class="service-price">₱1,500</p>
                    <ul class="serv-list">
                        <li>Complete Exterior Wash and Wax</li>
                        <li>Full Interior Deep Cleaning (seats, carpets, dashboard, trunk)</li>
                        <li>Polishing & Water Spot Removal</li>
                        <li>Tire & Rim Detailing</li>
                    </ul>
                    <span class="best"><b>Best For:</b> Thorough cleaning inside & out.</span>
                </div>
            </div>
            <div class="service-card">
                <div class="service-icon-container">
                    <div class="service-icon"><img src="../assets/images/serv4.png" alt="Ultimate Package"></div>
                </div>
                <div class="service-content">
                    <h3 class="service-name">Ultimate Package</h3>
                    <p class="service-price">₱2,500</p>
                    <ul class="serv-list">
                        <li>All services from <b>Premium Detailing</b></li>
                        <li>Engine Bay Cleaning</li>
                        <li>Headlight Restoration</li>
                        <li>Paint Protection (Waxing)</li>
                        <li>Odor Removal / Anti-Bacterial Mist</li>
                    </ul>
                    <span class="best"><b>Best For:</b> Showroom quality / resale prep.</span>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section" id="about">
        <h2 class="about-title">About Us</h2>
        <div class="about-container">
            <h2>About Our Car Wash</h2>
            <p>
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptas omnis mollitia consequuntur recusandae accusantium in
                maxime perspiciatis quam voluptates laborum quod porro dicta perferendis debitis, quidem ea aliquid enim quibusdam?
            </p>
            <p>
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptas omnis mollitia consequuntur recusandae accusantium in
                maxime perspiciatis quam voluptates laborum quod porro dicta perferendis debitis, quidem ea aliquid enim quibusdam?
            </p>

            <div class="team-section">
                <h2 class="our-team">Our Team</h2>

                <div class="team top-team">
                    <div class="member">
                        <h4>Eivan Kyel C. Bauzon</h4>
                        <p>Project Manager</p>
                    </div>
                    <div class="member">
                        <h4>Paul Vincent F. Balolong</h4>
                        <p>Programmer</p>
                    </div>
                </div>

                <div class="team bottom-team">
                    <div class="member">
                        <h4>Verlance Jhercey M. Garcia</h4>
                        <p>Documentation Specialist</p>
                    </div>
                    <div class="member">
                        <h4>Jenmike Kenneth R. Gutierrez</h4>
                        <p>Database Administrator</p>
                    </div>
                    <div class="member">
                        <h4>Christian Divan B. Lucas</h4>
                        <p>Systems Analyst</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Car Wash Booking System. All rights reserved.</p>
    </footer>
    <script src='../assets/toastify.js'></script>
    <script src="../assets/script.js"></script>
</body>

</html>