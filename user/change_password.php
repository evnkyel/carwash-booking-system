<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($current_password, $hashed_password)) {
        $_SESSION['toast_type'] = 'error';
        $_SESSION['toast_message'] = 'Current password is incorrect.';
    } elseif ($new_password !== $confirm_password) {
        $_SESSION['toast_type'] = 'error';
        $_SESSION['toast_message'] = 'New passwords do not match.';
    } elseif (strlen($new_password) < 6) {
        $_SESSION['toast_type'] = 'error';
        $_SESSION['toast_message'] = 'Password must be at least 6 characters long.';
    } else {
        $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        $update->bind_param("si", $new_hashed, $user_id);
        if ($update->execute()) {
            $_SESSION['toast_type'] = 'success';
            $_SESSION['toast_message'] = 'Password changed successfully!';
        } else {
            $_SESSION['toast_type'] = 'error';
            $_SESSION['toast_message'] = 'Failed to change password.';
        }
    }

    header("Location: change_password.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/change_password.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/toastify.css">
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
            <li><a href="index.php#home" class="nav-link active">Home</a></li>
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

    <div class="change-container">
        <h2>Change Password</h2>

        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="current_password">Current Password</label>
            <input type="password" name="current_password" placeholder="Enter current password" required>

            <label for="new_password">New Password</label>
            <input type="password" name="new_password" placeholder="Enter new password" required>

            <label for="confirm_password">Confirm New Password</label>
            <input type="password" name="confirm_password" placeholder="Confirm new password" required>

            <button type="submit" class="btn"><i class="fas fa-key"></i> Change Password</button>

            <a href="profile.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Profile</a>
        </form>
    </div>

    <script src="../assets/toastify.js"></script>
    <script src="../assets/script.js"></script>

    <?php if (isset($_SESSION['toast_message'])): ?>
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                Toastify({
                    text: "<?= addslashes($_SESSION['toast_message']); ?>",
                    duration: 3000,
                    gravity: 'top',
                    position: 'center',
                    close: true,
                    style: {
                        background: "<?= $_SESSION['toast_type'] === 'success' ? 'linear-gradient(to right, #00b09b, #96c93d)' : 'linear-gradient(to right, #ff5f6d, #ffc371)' ?>",
                        borderRadius: '12px',
                        fontSize: '16px',
                        textAlign: 'center'
                    }
                }).showToast();
            });
        </script>
    <?php unset($_SESSION['toast_message'], $_SESSION['toast_type']);
    endif; ?>

</body>

</html>