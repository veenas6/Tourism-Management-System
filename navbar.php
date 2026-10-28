<?php 
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar">
    <div class="container">
        <a href="index.php" class="logo">
            <i class="fas fa-mountain"></i> Panchgani
        </a>
        <ul class="nav-links">
            <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                <i class="fas fa-home"></i> Home
            </a></li>
            <li><a href="places.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'places.php' ? 'active' : ''; ?>">
                <i class="fas fa-map-marker-alt"></i> Destinations
            </a></li>
            <li><a href="booking.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'booking.php' ? 'active' : ''; ?>">
                <i class="fas fa-calendar-check"></i> Book Now
            </a></li>
            <li><a href="contact.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">
                <i class="fas fa-envelope"></i> Contact
            </a></li>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <?php if($_SESSION['email'] == 'admin@panchgani.com'): ?>
                    <li><a href="admin.php" style="color: #f59e0b;">
                        <i class="fas fa-user-shield"></i> Admin
                    </a></li>
                <?php endif; ?>
                <li>
                    <a href="logout.php" style="background: rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 20px;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <a href="login.php" style="background: white; color: #6366f1; padding: 0.5rem 1.5rem; border-radius: 20px; font-weight: 600;">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<nav class="navbar">
    <div class="container">
        <a href="index.php" class="logo"><i class="fas fa-mountain"></i> Panchgani</a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="places.php">Destinations</a></li>
            <li><a href="booking.php">Book Now</a></li>
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php" style="color: #ff4d4d; font-weight: bold;"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">