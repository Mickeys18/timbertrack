<?php
session_start();
include('db_connect.php');

// Security Check
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $wood_type = $_POST['wood_type'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $unit = $_POST['unit'];
    $desc = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "INSERT INTO products (wood_type, product_category, price_ksh, measurement_unit, description) 
            VALUES ('$wood_type', '$category', '$price', '$unit', '$desc')";

    if ($conn->query($sql) === TRUE) {
        $message = "<div style='color:green; padding:10px;'>Product added successfully!</div>";
    } else {
        $message = "<div style='color:red;'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Timber | Staff Portal</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #fdfbf7; margin: 0; display: flex; }
        .sidebar { width: 250px; height: 100vh; background: #3e2723; color: white; padding: 20px; position: fixed; }
        .content { margin-left: 290px; padding: 40px; width: 100%; }
        .form-card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); max-width: 600px; }
        .input-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #5c4033; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; }
        .btn-save { background: #3e2723; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer; font-weight: bold; width: 100%; }
        .btn-save:hover { background: #8b5a2b; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>TimberTrack</h2>
    <hr>
    <p><a href="admin_dashboard.php" style="color:white; text-decoration:none;">← Back to Dashboard</a></p>
</div>

<div class="content">
    <h1>Add New Product</h1>
    <?php echo $message; ?>

    <div class="form-card">
        <form method="POST">
            <div class="input-group">
                <label>Wood Type</label>
                <select name="wood_type" required>
                    <option value="Cypress">Cypress</option>
                    <option value="Pine">Pine</option>
                    <option value="Bluegum">Bluegum</option>
                    <option value="Grevillea">Grevillea</option>
                    <option value="Mahogany">Mahogany</option>
                </select>
            </div>

            <div class="input-group">
                <label>Product Category</label>
                <select name="category" required>
                    <option value="Frames">Frames</option>
                    <option value="Cladding">Cladding</option>
                    <option value="Steps">Steps</option>
                    <option value="Doors">Doors</option>
                    <option value="Beds">Beds</option>
                    <option value="Boards">Boards</option>
                </select>
            </div>

            <div class="input-group">
                <label>Price (Ksh)</label>
                <input type="number" step="0.01" name="price" placeholder="e.g. 4500" required>
            </div>

            <div class="input-group">
                <label>Measurement Unit</label>
                <input type="text" name="unit" value="feet" placeholder="feet, pieces, or sqm" required>
            </div>

            <div class="input-group">
                <label>Description</label>
                <textarea name="description" rows="3" placeholder="Describe the quality, age, or finish..."></textarea>
            </div>

            <button type="submit" class="btn-save">Save to Catalog</button>
        </form>
    </div>
</div>

</body>
</html>