<?php include 'db.php'; ?>

<?php
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $error = 'Email and password are required!';
    } else {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                
                // Redirect based on user type
                if ($user['email'] == 'admin@panchgani.com') {
                    header('Location: admin.php');
                } else {
                    header('Location: index.php');
                }
                exit();
            } else {
                $error = 'Invalid password!';
            }
        } else {
            $error = 'User not found!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Panchgani Tourism</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="form-container">
        <h2><i class="fas fa-sign-in-alt"></i> Login</h2>
        
        <?php if($error): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Login</button>
        </form>
        
        <p style="text-align: center; margin-top: 1rem;">
            Don't have an account? <a href="register.php">Register here</a>
        </p>
        
        <p style="text-align: center; margin-top: 0.5rem; font-size: 0.9rem; color: #666;">
            <strong>Admin Login:</strong> admin@panchgani.com / admin123
        </p>
    </div>
</body>
</html>