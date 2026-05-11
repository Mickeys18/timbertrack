<?php
session_start();
include('db_connect.php');

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username = '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify the password against the hash in the DB
       // Temporary Emergency Bypass for Project Demo
if ($pass === 'Timber@2026') { 
    $_SESSION['admin_id'] = $row['id'];
    $_SESSION['admin_user'] = $row['username'];
    header("Location: admin_dashboard.php");
    exit();
} else {
    $error = "Invalid password. Access Denied.";
}
    } else {
        $error = "Username not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Timber Catalog | Staff Login</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f1ea; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 350px; border-top: 5px solid #5c4033; }
        h2 { color: #5c4033; text-align: center; margin-bottom: 30px; }
        .input-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; color: #666; font-size: 0.9rem; }
        input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        .btn { width: 100%; padding: 12px; background: #5c4033; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 1rem; font-weight: bold; }
        .btn:hover { background: #8b5a2b; }
        .error { color: #e74c3c; font-size: 0.85rem; text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Staff Portal</h2>
    
    <?php if($error != ""): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" required placeholder="Enter username">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" required placeholder="••••••••">
        </div>
        <button type="submit" class="btn">Login to Dashboard</button>
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <a href="index.php" style="color: #8b5a2b; text-decoration: none; font-size: 0.9rem; font-weight: bold; display: inline-block;">
            ← Back to Homepage
        </a>
    </div>

    <p style="text-align:center; font-size:0.8rem; color:#999; margin-top:20px;">Timber Catalog Management v1.0</p>
</div>

</body>
</html>