
<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panchgani Tourism - Discover Paradise</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Discover Panchgani</h1>
            <p>Where Nature Meets Serenity in the Western Ghats</p>
            <a href="#destinations" class="btn">
                Explore Now <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- Stats Section -->
    <div class="stats">
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-mountain"></i>
                <h3>6</h3>
                <p>Top Attractions</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-utensils"></i>
                <h3>50+</h3>
                <p>Food Spots</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3>10k+</h3>
                <p>Happy Visitors</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-star"></i>
                <h3>4.8</h3>
                <p>Rating</p>
            </div>
        </div>
    </div>

    <!-- Featured Destinations -->
    <section id="destinations" style="padding-top: 2rem;">
        <div class="section-title">
            <h2>Popular Destinations</h2>
            <p>Explore the most breathtaking locations and food spots in Panchgani</p>
        </div>

        <div class="places-grid">
            <?php
            // Specific image mapping for real Panchgani places
            $place_images = [ 
            "Table Land" => "images/table_land.jpeg",
            "Sydney Point" => "images/sydney_point.jpg",
            "Parsi Point" => "images/parsi_point.jpg",
            "Mapro Garden" => "images/mapro.webp",
            "Lucky Bakery" => "images/lucky_bakery.jpg",
            "Hilltop Ice Cream" => "images/hilltop.jpeg"    
                ];

            $sql = "SELECT * FROM places ORDER BY id";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($place = mysqli_fetch_assoc($result)) {
                    // Get specific image or fallback to database image
                    $img_url = isset($place_images[$place['name']]) ? $place_images[$place['name']] : $place['image'];
                    
                    // Special badges for food places
                    $badge = '';
                    if($place['name'] == 'Lucky Bakery' || $place['name'] == 'Hilltop Ice Cream') {
                        $badge = '<span style="position: absolute; top: 15px; right: 15px; background: #ec4899; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; z-index: 10;"><i class="fas fa-utensils"></i> Food & Drink</span>';
                    } else {
                        $badge = '<span style="position: absolute; top: 15px; right: 15px; background: #6366f1; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; z-index: 10;"><i class="fas fa-camera"></i> Scenic</span>';
                    }
                    
                    echo '
                    <div class="place-card" onclick="window.location.href=\'booking.php?place_id='.$place['id'].'\'">
                        <div style="position: relative; overflow: hidden; height: 250px;">
                            '.$badge.'
                            <img src="'.$img_url.'" 
                             style="width:100%; height:200px; object-fit:cover;"
                             onerror="this.src=\'images/default.jpg\'">
                            <div class="place-overlay">
                                <button class="btn btn-secondary">Book Visit</button>
                            </div>
                        </div>
                        <div class="place-content">
                            <h3>'.$place['name'].'</h3>
                            <p>'.$place['description'].'</p>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                                <span class="price-tag"><i class="fas fa-ticket-alt"></i> ₹100/visit</span>
                                <span style="color: #f59e0b;"><i class="fas fa-star"></i> 4.9</span>
                            </div>
                        </div>
                    </div>';
                }
            }
            ?>
        </div>
    </section>

    <!-- Special Section for Food Lovers -->
    <section style="background: rgba(255,255,255,0.1); border-radius: 30px; margin: 3rem auto; padding: 3rem;">
        <div class="section-title">
            <h2><i class="fas fa-cookie-bite" style="color: #ec4899;"></i> Foodie Specials</h2>
            <p>Don't miss these famous food destinations</p>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <!-- Lucky Bakery Feature -->
            <div class="glass-card" style="display: flex; gap: 1.5rem; align-items: center;">
                <img src="images/lucky_bakery.jpg" 
                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 15px;">
                <div>
                    <h3 style="color: white; margin-bottom: 0.5rem;">Lucky Bakery</h3>
                    <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem;">Famous for strawberry cream rolls and fresh cookies since 1985.</p>
                    <a href="booking.php?place_id=5" class="btn" style="padding: 0.5rem 1rem; font-size: 0.9rem; margin-top: 0.5rem;">Visit Now</a>
                </div>
            </div>
            
            <!-- Hilltop Ice Cream Feature -->
            <div class="glass-card" style="display: flex; gap: 1.5rem; align-items: center;">
                <img src="images/hilltop.jpeg"" 
                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 15px;">
                <div>
                    <h3 style="color: white; margin-bottom: 0.5rem;">Hilltop Ice Cream</h3>
                    <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem;">Best strawberry ice cream with valley view. Perfect sunset spot!</p>
                    <a href="booking.php?place_id=6" class="btn" style="padding: 0.5rem 1rem; font-size: 0.9rem; margin-top: 0.5rem;">Visit Now</a>
                </div>
            </div>
        </div>
    </section>

    <script src="main.js"></script>
</body>
</html>