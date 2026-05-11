<?php
include('db_connect.php');

$order_details = null;
$error = "";

if (isset($_POST['tracking_code'])) {
    $code = mysqli_real_escape_string($conn, $_POST['tracking_code']);
    
    // Search for the booking matching the unique TMB code
    $sql = "SELECT * FROM bookings WHERE tracking_code = '$code'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $order_details = $result->fetch_assoc();
    } else {
        $error = "No order found with that tracking code. Please check and try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track My Order | TimberTrack Kenya</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #fdfbf7; padding: 40px; color: #3e2723; }
        .track-box { max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center; border-top: 8px solid #5c4033; }
        input { width: 100%; padding: 12px; margin: 20px 0; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 1.1rem; text-align: center; }
        .btn-track { background: #5c4033; color: white; border: none; padding: 12px 30px; border-radius: 8px; cursor: pointer; font-weight: bold; width: 100%; }
        .status-result { margin-top: 30px; padding: 20px; border-radius: 8px; background: #f9f5f0; text-align: left; border-left: 5px solid #8b5a2b; }
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; color: white; text-transform: uppercase; }
        .pending { background: #f39c12; }
        .confirmed { background: #2ecc71; }
    </style>
</head>
<body>

<div class="track-box">
    <h2>Track Your Order</h2>
    <p>Enter your unique TMB tracking code to see your status.</p>

    <form method="POST">
        <input type="text" name="tracking_code" placeholder="e.g. TMB-4921" required>
        <button type="submit" class="btn-track">Check Status</button>
    </form>

    <?php if($error): ?>
        <p style="color: #e74c3c; margin-top: 20px;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if($order_details): ?>
        <div class="status-result">
            <p><strong>Customer:</strong> <?php echo $order_details['customer_name']; ?></p>
            <p><strong>Total Amount:</strong> Ksh <?php echo number_format($order_details['total_amount_ksh'], 2); ?></p>
            <p><strong>Order Status:</strong> 
                <span class="badge <?php echo strtolower($order_details['status']); ?>">
                    <?php echo $order_details['status']; ?>
                </span>
            </p>
            <p style="font-size: 0.85rem; color: #666; margin-top: 10px;">Ordered on: <?php echo date('d M, Y', strtotime($order_details['created_at'])); ?></p>
        </div>
    <?php endif; ?>
    
    <p style="margin-top: 20px;"><a href="index.php" style="color: #8b5a2b; text-decoration: none;">← Return Home</a></p>
</div>

</body>
</html>