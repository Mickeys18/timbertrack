<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Delete the items linked to this booking first (The "Children")
    $conn->query("DELETE FROM order_items WHERE booking_id = $id");

    // 2. Now delete the booking itself (The "Parent")
    $sql = "DELETE FROM bookings WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_bookings.php?msg=cancelled");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header("Location: admin_bookings.php");
}
?>