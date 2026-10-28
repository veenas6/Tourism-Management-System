<?php include 'db.php'; ?>

<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';
$places_result = mysqli_query($conn, "SELECT * FROM places ORDER BY name");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $place_id = sanitize($_POST['place_id']);
    $date = sanitize($_POST['date']);
    $people = sanitize($_POST['people']);
    $user_id = $_SESSION['user_id'];
    
    if (empty($place_id) || empty($date) || empty($people)) {
        $error = 'All fields are required!';
    } else {
        $sql = "INSERT INTO bookings (user_id, place_id, date, people) 
                VALUES ('$user_id', '$place_id', '$date', '$people')";
        
        if (mysqli_query($conn, $sql)) {
            $success = 'Booking confirmed! Redirecting...';
        } else {
            $error = 'Error: ' . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Your Visit - Panchgani</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding-top: 100px;">
    <?php include 'navbar.php'; ?>
    
    <div class="container">
        <div class="form-container">
            <h2 style="text-align: center; margin-bottom: 0.5rem; color: var(--dark);">
                <i class="fas fa-calendar-check" style="color: var(--primary);"></i>
                Book Your Adventure
            </h2>
            <p style="text-align: center; color: #64748b; margin-bottom: 2rem;">Fill in the details to reserve your spot</p>
            
            <?php if($error): ?>
                <div class="message error" style="background: #fee2e2; color: #dc2626; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if($success): ?>
                <div class="message success" style="background: #d1fae5; color: #059669; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="" id="bookingForm">
                <div class="form-group">
                    <label><i class="fas fa-map-marker-alt"></i> Select Destination</label>
                    <select name="place_id" id="placeSelect" required style="cursor: pointer;">
                        <option value="">Choose a destination...</option>
                        <?php
                        mysqli_data_seek($places_result, 0);
                        while($place = mysqli_fetch_assoc($places_result)) {
                            $selected = (isset($_GET['place_id']) && $_GET['place_id'] == $place['id']) ? 'selected' : '';
                            echo '<option value="'.$place['id'].'" '.$selected.'>'.$place['name'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-calendar"></i> Visit Date</label>
                    <input type="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-users"></i> Number of Visitors</label>
                    <input type="number" name="people" id="peopleCount" min="1" max="20" value="1" required>
                    <small style="color: #64748b; display: block; margin-top: 0.5rem;">
                        Total Cost: ₹<span id="totalCost">500</span> 
                        <span style="font-size: 0.8rem;">(₹500 per person)</span>
                    </small>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    <span>Confirm Booking</span>
                    <div class="spinner"></div>
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0;">
                <a href="index.php" style="color: var(--primary); text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Back to Home
                </a>
            </div>
        </div>
    </div>

    <script src="main.js"></script>
    <script>
        // Dynamic price calculation
        document.getElementById('peopleCount').addEventListener('input', function() {
            const count = this.value;
            const cost = count * 500;
            document.getElementById('totalCost').textContent = cost;
        });
        
        // Form submission animation
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            btn.style.opacity = '0.7';
            btn.querySelector('span').textContent = 'Processing...';
        });
    </script>
</body>
</html>