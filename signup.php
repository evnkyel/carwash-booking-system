<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Wash Booking System - Sign Up</title>
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://kit.fontawesome.com/297c9c66b4.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="menu-overlay"></div>

    <nav class="side-menu">
        <ul class="menu-list">
            <li><a href="index.php"><i class="fas fa-home nav-icon"></i> Home</a></li>
            <li><a href="#services"><i class="fas fa-car nav-icon"></i> Services</a></li>
            <li><a href="#booking"><i class="fas fa-calendar-plus nav-icon"></i> Book Now</a></li>
            <li><a href="#my-bookings"><i class="fas fa-calendar-check nav-icon"></i> My Bookings</a></li>
            <li><a href="#about-us"><i class="fas fa-info-circle nav-icon"></i> About Us</a></li>
            <li><a href="#contact"><i class="fas fa-phone nav-icon"></i> Contact</a></li>
            <li><a href="login.php"><i class="fas fa-user nav-icon"></i> Profile</a></li>
        </ul>
    </nav>

    <header class="header">
        <div class="menu-icon" id="menuIcon">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="logo">Sign up</div>
        <div class="notification"><i class="fa-solid fa-bell"></i></div>
    </header>

    <section class="login-section">
        <div class="login-container signup-form">
            <h2>Create Account</h2>
            <form action="signup_process.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Choose a username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm your password" required>
                </div>
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="terms" required> I agree to the <a href="#terms">Terms & Conditions</a>
                    </label>
                </div>
                <button type="submit" class="btn-primary">Sign Up</button>
            </form>
            <div class="signup-link">
                <p>Already have an account? <a href="login.php">Sign In</a></p>
            </div>
        </div>
    </section>

    <script src="assets/script.js"></script>
</body>
</html>