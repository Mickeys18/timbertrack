<?php
include('db_connect.php');

$id = $_GET['id'];
// Fetch booking details + join with products via order_items
$sql = "SELECT b.*, p.wood_type, p.product_category, oi.quantity 
        FROM bookings b 
        JOIN order_items oi ON b.id = oi.booking_id 
        JOIN products p ON oi.product_id = p.id 
        WHERE b.id = $id AND b.status = 'Confirmed'";

$result = $conn->query($sql);
$data = $result->fetch_assoc();

if (!$data) {
    die("Error: Receipt only available for confirmed orders.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Receipt - <?php echo $data['tracking_code']; ?></title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; background: #eee; padding: 20px; }
        .receipt-card { background: white; max-width: 400px; margin: 0 auto; padding: 30px; border: 1px dashed #000; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .center { text-align: center; }
        .line { border-top: 1px dashed #000; margin: 15px 0; }
        .flex { display: flex; justify-content: space-between; margin-bottom: 5px; }
        @media print { .no-print { display: none; } body { background: white; padding: 0; } .receipt-card { box-shadow: none; border: none; } }
    </style>
</head>
<body>

<div class="receipt-card">
    <div class="center">
        <h2 style="margin:0;">TIMBERTRACK KENYA</h2>
        <p style="font-size:0.8rem;">Mombasa, Kenya | TUM Project<br>Quality Timber Solutions</p>
    </div>

    <div class="line"></div>
    <div class="center"><strong>OFFICIAL RECEIPT</strong></div>
    <div class="line"></div>

    <div class="flex"><span>Date:</span> <span><?php echo date('d-m-Y'); ?></span></div>
    <div class="flex"><span>Code:</span> <span><strong><?php echo $data['tracking_code']; ?></strong></span></div>
    <div class="flex"><span>Customer:</span> <span><?php echo $data['customer_name']; ?></span></div>
    
    <div class="line"></div>
    
    <div class="flex">
        <span><?php echo $data['wood_type']; ?> (x<?php echo $data['quantity']; ?>)</span>
        <span>Ksh <?php echo number_format($data['total_amount_ksh'], 2); ?></span>
    </div>
    
    <div class="line"></div>
    <div class="flex" style="font-size: 1.2rem; font-weight: bold;">
        <span>TOTAL PAID:</span>
        <span>KES <?php echo number_format($data['total_amount_ksh'], 2); ?></span>
    </div>
    <div class="line"></div>

    <div class="center" style="font-size: 0.8rem;">
       <p>Status: PAID VIA <?php echo strtoupper($data['payment_method']); ?></p>
        <p>Thank you for shopping with us!</p>
        <button onclick="window.print()" class="no-print" style="cursor:pointer; padding: 5px 15px; background: #3e2723; color:white; border:none; border-radius:3px;">🖨️ Print Receipt</button>
    </div>
</div>

</body>
</html>