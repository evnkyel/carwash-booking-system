<?php
include 'config/config.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Wash Booking System</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/about.css">
    <link id="themeStylesheet" rel="stylesheet" href="">

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
            <li><a href="login.php"><i class="fas fa-sign-out-alt nav-icon"></i> Log In</a></li>
        </ul>
    </nav>

    <header class="header">
        <div class="logo">Car Wash</div>
        <ul class="nav-links">
            <li><a href="#home" class="nav-link active">Home</a></li>
            <li><a href="#services" class="nav-link">Services</a></li>
            <li><a href="booking.php" class="nav-link">Book Now</a></li>
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
            <?php
            $result = $conn->query("SELECT * FROM services");
            while ($row = $result->fetch_assoc()) {
                $descItems = explode("•", $row['description']);

                echo "
                <div class='service-card'>
                    <div class='service-icon-container'>
                        <div class='service-icon'>
                            <img src='assets/images/{$row['image']}' alt='{$row['service_name']}'>
                        </div>
                    </div>
                    <div class='service-content'>
                        <h3 class='service-name'>{$row['service_name']}</h3>
                        <p class='service-price'>₱" . number_format($row['price'], 2) . "</p>
                        <ul class='service-desc'>";
                            foreach ($descItems as $item) {
                                $trimmed = trim($item);
                                if (!empty($trimmed)) {
                                    echo "<li>$trimmed</li>";
                                }
                            }
                echo "  </ul>
                        <span class='best'><b>Best For:</b> {$row['best_for']}</span>
                    </div>
                </div>";
            }
            ?>
        </div>
    </section>

    <section class="about-section" id="about">
        <h2 class="about-title">About Us</h2>
        <div class="about-container">
            <?php
            $aboutQuery = $conn->query("SELECT * FROM about_info LIMIT 1");
            $about = $aboutQuery->fetch_assoc();
            ?>

            <h2><?= htmlspecialchars($about['title']) ?></h2>
            <p><?= nl2br(htmlspecialchars($about['description'])) ?></p>

            <div class="team-section">
                <h2 class="our-team">Our Team</h2>

                <?php
                $result = $conn->query("SELECT * FROM team_members ORDER BY id ASC");
                $members = [];

                while ($row = $result->fetch_assoc()) {
                    $members[] = $row;
                }

                $top_members = array_slice($members, 0, 2);
                $bottom_members = array_slice($members, 2);
                ?>

                <div class="top-team">
                    <?php foreach ($top_members as $member): ?>
                        <div class="member">
                            <?php if (!empty($member['photo'])): ?>
                                <img src="uploads/<?= htmlspecialchars($member['photo']) ?>" alt="<?= htmlspecialchars($member['name']) ?>" style="width:120px;height:120px;border-radius:50%;object-fit:cover;margin-bottom:10px;">
                            <?php endif; ?>
                            <h4><?= htmlspecialchars($member['name']) ?></h4>
                            <p><?= htmlspecialchars($member['role']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="bottom-team">
                    <?php foreach ($bottom_members as $member): ?>
                        <div class="member">
                            <?php if (!empty($member['photo'])): ?>
                                <img src="uploads/<?= htmlspecialchars($member['photo']) ?>" alt="<?= htmlspecialchars($member['name']) ?>" style="width:120px;height:120px;border-radius:50%;object-fit:cover;margin-bottom:10px;">
                            <?php endif; ?>
                            <h4><?= htmlspecialchars($member['name']) ?></h4>
                            <p><?= htmlspecialchars($member['role']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Car Wash Booking System. All rights reserved.</p>
    </footer>
    <script src="assets/script.js"></script>
    <script src="assets/theme.js"></script>
    </script>
</body>

</html>