<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard | TimberTrack</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #fdfbf7; padding: 40px; text-align: center; }
        .menu-container { display: flex; justify-content: center; gap: 20px; margin-top: 50px; }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 250px; text-decoration: none; color: #3e2723; transition: 0.3s; }
        .card:hover { transform: translateY(-5px); border: 2px solid #8b5a2b; }
        h1 { color: #8b5a2b; }
    </style>
</head>
<body>
    <h1>TimberTrack Admin Control Center</h1>
    <p>Welcome, Administrator. Select a module to manage.</p>

    <div class="menu-container">
        <a href="admin_dashboard.php" class="card">
            <h2>📦 Inventory</h2>
            <p>Update stock, change prices, and edit wood types.</p>
        </a>

        <a href="admin_bookings.php" class="card">
            <h2>📋 Orders</h2>
            <p>Confirm payments (M-Pesa/Cash) and print receipts.</p>
        </a>

        <a href="logout.php" class="card" style="border-top: 4px solid #c62828;">
            <h2>🚪 Logout</h2>
            <p>Securely end your session.</p>
        </a>
    </div>
</body>
</html>