<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Wash Booking System</title>
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
        <div class="logo">Sign in</div>
        <div class="notification"><i class="fa-solid fa-bell"></i></div>
    </header>

    <section class="login-section">
        <div class="login-container">
            <h2>Sign In</h2>
            <form action="login_process.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <a href="#forgot-password" class="forgot-password">Forgot Password?</a>
                </div>
                <button type="submit" class="btn-primary">Sign in</button>
            </form>
            <div class="signup-link">
                <p>Don't have an account? <a href="signup.php">Create Account</a></p>
            </div>
        </div>
    </section>

    <script src="assets/script.js"></script>
</body>
</html>