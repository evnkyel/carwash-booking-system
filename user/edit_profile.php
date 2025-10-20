<?php
session_start();
include '../config/config.php';
include '../classes/User.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user = new User($conn);

$userData = $user->getUserById($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if ($name && $email && $phone) {
        if ($user->updateProfile($user_id, $name, $email, $phone)) {
            $_SESSION['profile_updated'] = true;
            $_SESSION['name'] = $name;
            header("Location: profile.php");
            exit();
        } else {
            $error = "Failed to update profile.";
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/user/edit_profile.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
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

    <div class="edit-container">
        <h2>Edit Profile</h2>

        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="name">Full Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($userData['name']) ?>" required>

            <label for="email">Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($userData['email']) ?>" required>

            <label for="phone">Phone</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($userData['phone']) ?>" required>

            <button type="submit" class="btn"><i class="fas fa-save"></i> Save Changes</button>

            <a href="settings.php" class="btn back-btn"><i class="fas fa-arrow-left"></i> Back to Settings</a>
        </form>
    </div>
    <script src="../assets/script.js"></script>
</body>

</html>