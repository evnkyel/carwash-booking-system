<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> User Profile</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom, #B2EBF2, #E0F7FA);
            height: 100vh;
        }

        .header-guest {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            background: linear-gradient(90deg, #B2EBF2, #c4f0ff);
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 100;
        }

        .guest-section {
            display: flex;
            justify-content: center;
        }

        .guest-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 280px;
            background: white;
            padding: 50px 50px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #4d4d4d;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            font-size: 16px;
        }

        a {
            color: #0077cc;
            font-weight: bold;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="profile-menu-overlay"></div>

    <nav class="profile-menu">
        <ul class="profile-list">
            <li><a href="profile.php" class="active"><i class="fas fa-user-circle nav-icon"></i> My Profile</a></li>
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

    <section class="guest-section">
        <div class="guest-card">
            <h2>Welcome, Guest!</h2>
            <p>Please <a href="login.php">log in</a> or <a href="signup.php">create an account</a> to view your profile.</p>
        </div>
    </section>
    <script src="assets/script.js"></script>
</body>

</html>