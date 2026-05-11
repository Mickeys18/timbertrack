<?php
session_start();
include('db_connect.php');

// Security Check: Only logged-in staff can delete
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Check if an ID was actually sent
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL to delete the specific timber product
    $sql = "DELETE FROM products WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to dashboard with a success message (optional)
        header("Location: admin_dashboard.php?msg=deleted");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header("Location: admin_dashboard.php");
}
?>