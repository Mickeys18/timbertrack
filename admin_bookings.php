<?php
session_start();
include('db_connect.php');

// Security Check: Staff only
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle Status Update (Confirming an Order)
if (isset($_GET['confirm_id'])) {
    $c_id = $_GET['confirm_id'];
    $conn->query("UPDATE bookings SET status = 'Confirmed' WHERE id = $c_id");
    header("Location: admin_bookings.php");
}

// Fetch all bookings, newest first
$sql = "SELECT * FROM bookings ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<?php
function getStockStatus($quantity, $category) {
    if ($quantity <= 0) {
        return "Out of Stock";
    }
    
    // Rule for items measured in feet (Timber, Boards, etc.)
    if (strpos(strtolower($category), 'timber') !== false || strpos(strtolower($category), 'board') !== false) {
        if ($quantity < 100) return "Low Stock";
    } 
    // Rule for unit items (Doors, Frames)
    else {
        if ($quantity < 50) return "Low Stock";
    }
    
    return "In Stock";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Portal | Order Management</title>
    <style>
        :root { --dark: #3e2723; --primary: #795548; --bg: #efebe9; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg); margin: 0; display: flex; }
        .sidebar { width: 250px; height: 100vh; background: var(--dark); color: white; position: fixed; padding: 20px; }
        .main-content { margin-left: 290px; padding: 40px; width: 100%; }
        
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: var(--primary); color: white; }
        
        .badge { padding: 5px 12px; border-radius: 4px; font-size: 0.8rem; font-weight: bold; }
        .pending { background: #fff3e0; color: #ef6c00; }
        .confirmed { background: #e8f5e9; color: #2e7d32; }
        
        .btn-confirm { background: #2e7d32; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 0.85rem; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>TimberTrack</h2>
    <p>Staff: <strong><?php echo $_SESSION['admin_user']; ?></strong></p>
    <hr>
    <p><a href="admin_dashboard.php" style="color:white; text-decoration:none;">Inventory</a></p>
    <p><a href="admin_bookings.php" style="color:white; text-decoration:none;"><strong>Manage Orders</strong></a></p>
    <p><a href="logout.php" style="color: #ffab91; text-decoration:none;">Logout</a></p>
</div>

<div class="main-content">
    <h1>Customer Orders</h1>
    <p>Review bookings and update statuses below.</p>

    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Amount (Ksh)</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><strong><?php echo $row['tracking_code']; ?></strong></td>
                <td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row['customer_phone']; ?></td>
                <td>KES <?php echo number_format($row['total_amount_ksh'], 2); ?></td>
                <td>
                    <span class="badge <?php echo strtolower($row['status']); ?>">
                        <?php echo $row['status']; ?>
                    </span>
                </td>
                <td><?php echo date('d M', strtotime($row['created_at'])); ?></td>
<td>
    <?php if($row['status'] == 'Pending'): ?>
        <form method="POST" action="confirm_payment.php" style="display:flex; gap:5px;">
            <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
            <select name="pay_method" required style="padding:4px; border-radius:4px; border:1px solid #8b5a2b;">
                <option value="">Select Pay Method</option>
                <option value="M-Pesa">M-Pesa</option>
                <option value="Cash">Cash</option>
            </select>
            <button type="submit" style="background:#2e7d32; color:white; border:none; padding:5px 10px; border-radius:4px; cursor:pointer; font-size:0.8rem;">
                Confirm
            </button>
        </form>
    <?php else: ?>
        <div style="margin-bottom:5px;">
            <span style="font-size:0.8rem; color:#666;">Paid via: <strong><?php echo $row['payment_method']; ?></strong></span>
        </div>
        <a href="receipt.php?id=<?php echo $row['id']; ?>" target="_blank" style="color: #2e7d32; text-decoration: none; font-weight: bold; border: 1px solid #2e7d32; padding: 4px 8px; border-radius: 4px; font-size:0.85rem;">
            📄 View Receipt
        </a>
    <?php endif; ?>
</td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>