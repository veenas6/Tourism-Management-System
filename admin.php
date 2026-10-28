<?php include 'db.php'; ?>

<?php
// Check if user is admin
if (!isset($_SESSION['email']) || $_SESSION['email'] != 'admin@panchgani.com') {
    header('Location: login.php');
    exit();
}

// Handle booking status update
if (isset($_GET['update_status'])) {
    $booking_id = sanitize($_GET['booking_id']);
    $status = sanitize($_GET['status']);
    
    $sql = "UPDATE bookings SET status = '$status' WHERE id = '$booking_id'";
    mysqli_query($conn, $sql);
}

// Get all bookings
$bookings_sql = "SELECT b.*, u.name as user_name, u.email, p.name as place_name 
                 FROM bookings b 
                 JOIN users u ON b.user_id = u.id 
                 JOIN places p ON b.place_id = p.id 
                 ORDER BY b.created_at DESC";
$bookings_result = mysqli_query($conn, $bookings_sql);

// Get statistics
$stats_sql = "SELECT 
                COUNT(*) as total_bookings,
                SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled
              FROM bookings";
$stats_result = mysqli_query($conn, $stats_sql);
$stats = mysqli_fetch_assoc($stats_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Panchgani Tourism</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container">
        <h1 style="text-align: center; margin: 2rem 0; color: #2c3e50;">
            <i class="fas fa-user-shield"></i> Admin Dashboard
        </h1>
        
        <!-- Statistics -->
        <div class="stats">
            <div class="container">
                <div class="stat-card">
                    <i class="fas fa-calendar"></i>
                    <h3><?php echo $stats['total_bookings']; ?></h3>
                    <p>Total Bookings</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-check-circle"></i>
                    <h3><?php echo $stats['confirmed']; ?></h3>
                    <p>Confirmed</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-clock"></i>
                    <h3><?php echo $stats['pending']; ?></h3>
                    <p>Pending</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-times-circle"></i>
                    <h3><?php echo $stats['cancelled']; ?></h3>
                    <p>Cancelled</p>
                </div>
            </div>
        </div>
        
        <!-- Bookings Table -->
        <h2 style="margin: 2rem 0 1rem; color: #2c3e50;">All Bookings</h2>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Place</th>
                        <th>Date</th>
                        <th>People</th>
                        <th>Status</th>
                        <th>Booked On</th>
                        <th>Actions