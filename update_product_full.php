<?php
session_start();
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['admin_id'])) {
    $p_id = $_POST['product_id'];
    $wood = mysqli_real_escape_string($conn, $_POST['wood_type']);
    $cat = mysqli_real_escape_string($conn, $_POST['category']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $sql = "UPDATE products SET 
            wood_type = '$wood', 
            product_category = '$cat', 
            price_ksh = '$price', 
            stock_quantity = '$stock' 
            WHERE id = '$p_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Product Updated Successfully!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>