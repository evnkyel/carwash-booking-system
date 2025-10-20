<?php
session_start();

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
                textAlign: 'center'
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
    <title>Sign in</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel='stylesheet' href='assets/toastify.css'>
</head>

<body>
    <div class="profile-menu-overlay"></div>

    <nav class="profile-menu">
        <ul class="profile-list">
            <li><a href="profile.php"><i class="fas fa-user-circle nav-icon"></i> My Profile</a></li>
            <li><a href="settings.php"><i class="fas fa-cog nav-icon"></i> Settings</a></li>
            <li><a href="login.php"><i class="fas fa-sign-out-alt nav-icon"></i> Log In</a></li>
        </ul>
    </nav>

    <header class="header">
        <div class="logo">Car Wash</div>
        <ul class="nav-links">
            <li><a href="index.php#home" class="nav-link">Home</a></li>
            <li><a href="index.php#services" class="nav-link">Services</a></li>
            <li><a href="booking.php" class="nav-link">Book Now</a></li>
            <li><a href="index.php#about" class="nav-link">About Us</a></li>
            <li>
                <div class="profile-icon" role="button" aria-haspopup="true" aria-expanded="false" tabindex="0">
                    <i class="fas fa-user-circle nav-icon fa-2x" aria-hidden="true"></i>
                </div>
            </li>
        </ul>
    </header>

    <section class="login-section">
        <div class="login-container">
            <h2 class="login-title">Sign In</h2>
            <form action="login_process.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email"
                        value="<?php
                                if (isset($_SESSION['login_form_data']['email'])) {
                                    echo htmlspecialchars($_SESSION['login_form_data']['email']);
                                } elseif (isset($_COOKIE['remember_email'])) {
                                    echo htmlspecialchars($_COOKIE['remember_email']);
                                }
                                ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember"
                            <?php echo isset($_COOKIE['remember_email']) ? 'checked' : ''; ?>> Remember me
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
    <script src='assets/toastify.js'></script>
    <script src="assets/script.js"></script>
</body>

</html>
<?php unset($_SESSION['login_form_data']); ?>