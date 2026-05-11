<?php
session_start();
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Capture the data from the form
    $p_id = $_POST['product_id'];
    $new_qty = $_POST['new_qty'];

    // 2. Run the update
    $sql = "UPDATE products SET stock_quantity = '$new_qty' WHERE id = '$p_id'";

    if (mysqli_query($conn, $sql)) {
        // 3. Success! Show alert and go back
        echo "<script>
                alert('Stock updated to " . $new_qty . " successfully!');
                window.location.href='admin_dashboard.php';
              </script>";
    } else {
        // 4. Error! This will tell us if the database rejected it
        echo "Database Error: " . mysqli_error($conn);
    }
} else {
    echo "No data received.";
}
?>