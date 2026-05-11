<?php
include('db_connect.php');

$id = $_GET['id']; // Product ID from the catalog
$result = $conn->query("SELECT * FROM products WHERE id = $id");
$product = $result->fetch_assoc();

$success_msg = "";
$error_msg = ""; // Added to show stock errors

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['customer_phone']);
    $qty = intval($_POST['quantity']); // Ensure it is a number
    $available_stock = intval($product['stock_quantity']); // Get current stock
    
    // --- NEW FEATURE: STOCK CHECK ---
    if ($qty > $available_stock) {
        $error_msg = "
            <div style='background:#ffebee; border:1px solid #c62828; padding:15px; border-radius:8px; margin-bottom:20px; color:#c62828;'>
                ⚠️ <strong>Booking Failed:</strong> You requested $qty, but only $available_stock available in stock.
            </div>";
    } else {
        $total = $qty * $product['price_ksh'];
        
        // Generate a Unique Tracking Code
        $tracking = "TMB-" . rand(1000, 9999);

        // Insert into bookings table
        $sql = "INSERT INTO bookings (tracking_code, customer_name, customer_phone, total_amount_ksh, status) 
                VALUES ('$tracking', '$name', '$phone', '$total', 'Pending')";

        if ($conn->query($sql) === TRUE) {
            $booking_id = $conn->insert_id;
            
            // Link the product
            $conn->query("INSERT INTO order_items (booking_id, product_id, quantity) VALUES ('$booking_id', '$id', '$qty')");
            
            // --- NEW FEATURE: DEDUCT FROM STOCK ---
            $new_stock = $available_stock - $qty;
            $conn->query("UPDATE products SET stock_quantity = $new_stock WHERE id = $id");
            
            $success_msg = "
                <div style='background:#e8f5e9; border:1px solid #2e7d32; padding:20px; border-radius:8px; margin-bottom:20px;'>
                    <h3 style='color:#2e7d32; margin-top:0;'>Booking Successful!</h3>
                    <p>Your Unique Tracking Code is: <strong style='font-size:1.5rem;'>$tracking</strong></p>
                    <p>Please keep this code to check your order status.</p>
                    <a href='index.php' style='color:#3e2723; font-weight:bold;'>Return to Home</a>
                </div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Timber | <?php echo $product['wood_type']; ?></title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #fdfbf7; padding: 40px; color: #3e2723; }
        .booking-container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border-top: 8px solid #8b5a2b; }
        .product-preview { background: #f9f5f0; padding: 15px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #8b5a2b; }
        .stock-tag { background: #3e2723; color: white; padding: 4px 10px; border-radius: 4px; font-size: 0.9rem; float: right; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input { width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn-confirm { background: #8b5a2b; color: white; border: none; padding: 15px; width: 100%; border-radius: 8px; font-size: 1.1rem; font-weight: bold; cursor: pointer; }
        .btn-confirm:hover { background: #3e2723; }
    </style>
</head>
<body>

<div class="booking-container">
    <?php 
        if($success_msg != "") echo $success_msg; 
        if($error_msg != "") echo $error_msg;
    ?>

    <?php if($success_msg == ""): ?>
        <h2>Complete Your Booking</h2>
        <div class="product-preview">
            <span class="stock-tag">Stock: <?php echo $product['stock_quantity']; ?> Available</span>
            <strong>Item:</strong> <?php echo $product['wood_type'] . " " . $product['product_category']; ?><br>
            <strong>Price:</strong> Ksh <?php echo number_format($product['price_ksh'], 2); ?> per <?php echo $product['measurement_unit']; ?>
        </div>

        <form method="POST">
            <label>Your Full Name</label>
            <input type="text" name="customer_name" placeholder="Enter your name" required>

            <label>Phone Number (M-Pesa Number)</label>
            <input type="text" name="customer_phone" placeholder="e.g. 0712345678" required>

            <label>Quantity (Max: <?php echo $product['stock_quantity']; ?>)</label>
            <input type="number" name="quantity" id="booking_qty" min="1" max="<?php echo $product['stock_quantity']; ?>" value="1" required>

            <button type="submit" class="btn-confirm" id="submit_btn">Book & Get Tracking Code</button>
        </form>
    <?php endif; ?>
</div>

<script>
    // Visual alert if user tries to type more than available
    const qtyInput = document.getElementById('booking_qty');
    const maxStock = <?php echo $product['stock_quantity']; ?>;

    qtyInput.addEventListener('input', function() {
        if (parseInt(this.value) > maxStock) {
            alert("Warning: You cannot book more than " + maxStock + " units.");
            this.value = maxStock;
        }
    });
</script>

</body>
</html>