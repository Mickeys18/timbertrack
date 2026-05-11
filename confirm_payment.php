<?php
session_start();
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['admin_id'])) {
    $b_id = $_POST['booking_id'];
    $method = mysqli_real_escape_string($conn, $_POST['pay_method']);

    // 1. First, find out WHAT was ordered and HOW MUCH
    $item_sql = "SELECT product_id, quantity FROM order_items WHERE booking_id = $b_id";
    $item_result = $conn->query($item_sql);
    
    if ($item_row = $item_result->fetch_assoc()) {
        $p_id = $item_row['product_id'];
        $qty_ordered = $item_row['quantity'];

        // 2. Subtract the quantity from the products table
        $update_stock_sql = "UPDATE products SET stock_quantity = stock_quantity - $qty_ordered WHERE id = $p_id";
        $conn->query($update_stock_sql);
    }

    // 3. Update the booking status to Confirmed
    $sql = "UPDATE bookings SET status = 'Confirmed', payment_method = '$method' WHERE id = $b_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_bookings.php?msg=confirmed_and_subtracted");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>