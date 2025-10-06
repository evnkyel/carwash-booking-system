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
        <div class="logo">Home</div>
        <div class="notification"><i class="fa-solid fa-bell"></i></div>
    </header>

    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Book Your Car Wash Today!</h1>
            <p class="hero-description">
                Welcome to our Online Car Wash & Detailing Service! Book your wash anytime, 
                anywhere with just a few clicks. Whether it's a quick clean or premium detailing, we make it easy, fast, and hassle-free.
            </p>
            <a href="#booking"><button class="book-btn">Book Now</button></a>
        </div>
        <div class="hero-image"></div>
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

    <section class="services-section">
        <h2 class="service-title">Our Services</h2>
        <div class="service-list">
            <div class="service-card">
                <div class="service-icon-container">
                    <img src="assets/images/serv1.png" alt="Basic Package" class="service-icon">
                </div>
                <div class="service-content">
                    <h3 class="service-name">Basic Package</h3>
                    <p class="service-description">Includes exterior wash and dry.</p>
                </div>
            </div>
            <div class="service-card">
                <div class="service-icon-container">
                    <img src="assets/images/serv2.png" alt="Standard Package" class="service-icon">
                </div>
                <div class="service-content">
                    <h3 class="service-name">Standard Package</h3>
                    <p class="service-description">Includes exterior wash, tire cleaning, and window cleaning.</p>
                </div>
            </div>
            <div class="service-card">
                <div class="service-icon-container">
                    <img src="assets/images/serv3.png" alt="Premium Package" class="service-icon">
                </div>
                <div class="service-content">
                    <h3 class="service-name">Premium Package</h3>
                    <p class="service-description">Includes all Standard services plus waxing and interior vacuuming.</p>
                </div>
            </div>
            <div class="service-card">
                <div class="service-icon-container">
                    <img src="assets/images/serv4.png" alt="Ultimate Package" class="service-icon">
                </div>
                <div class="service-content">
                    <h3 class="service-name">Ultimate Package</h3>
                    <p class="service-description">Includes all Premium services plus engine cleaning and headlight restoration.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="view-services">
        <a href="#services" class="srv-btn">View all services</a>
    </section>  

    <footer>
        <p>&copy; 2025 Car Wash Booking System. All rights reserved.</p>
    </footer>

    <script src="assets/script.js"></script>
</body>
</html>