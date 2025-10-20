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
    <title>Sign Up</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel='stylesheet' href='assets/toastify.css'>
    <style>
        form {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0px 10px;
            margin: auto;
        }
    </style>
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
        <div class="login-container signup-form">
            <h2 class="login-title">Create Account</h2>
            <form action="signup_process.php" method="POST">
                <div class="form-group long">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name"
                        value="<?php echo isset($_SESSION['form_data']['name']) ? htmlspecialchars($_SESSION['form_data']['name']) : ''; ?>" required>
                </div>
                <div class="form-group short">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email"
                        value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>" required>
                </div>
                <div class="form-group short">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number"
                        value="<?php echo isset($_SESSION['form_data']['phone']) ? htmlspecialchars($_SESSION['form_data']['phone']) : ''; ?>" required>
                </div>
                <div class="form-group long">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                </div>
                <div class="form-group long">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm your password" required>
                </div>
                <div class="form-options">
                    <label class="Terms">
                        <input type="checkbox" name="terms" required> I agree to the <a class="termss" href="#terms">Terms & Conditions</a>
                    </label>
                </div>
                <button type="submit" class="btn-primary">Sign Up</button>
            </form>

            <div class="signup-link">
                <p>Already have an account? <a href="login.php">Sign In</a></p>
            </div>
        </div>
    </section>
    <script src='assets/toastify.js'></script>
    <script src="assets/script.js"></script>
</body>

</html>
<?php unset($_SESSION['form_data']); ?>