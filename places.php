<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Destinations - Panchgani</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="padding-top: 100px;">
    <?php include 'navbar.php'; ?>
    
    <div class="container">
        <div class="section-title"><h1>Explore Panchgani</h1></div>
        
        <div class="places-grid">
            <?php
            $sql = "SELECT * FROM places";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($place = mysqli_fetch_assoc($result)) {
                    echo '
                    <div class="place-card">
                        <img src="'.$place['image'].'" alt="'.$place['name'].'" class="place-image">
                        <div class="place-content">
                            <h3>'.$place['name'].'</h3>
                            <p>'.$place['description'].'</p>
                            <a href="booking.php?place_id='.$place['id'].'" class="btn" style="width:100%; text-align:center;">
                                Book Visit
                            </a>
                        </div>
                    </div>';
                }
            }
            ?>
        </div>
    </div>
    <script src="main.js"></script>
</body>
</html>