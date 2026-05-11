<?php
include('db_connect.php');
$id = $_GET['id'];
$res = $conn->query("SELECT * FROM products WHERE id = $id");
$p = $res->fetch_assoc();

// ALL CATEGORIES RESTORED
$categories = [
    "Softwood Timber", "Hardwood Timber", "Cladding", "Leaping Cuttings", 
    "Floor Boards", "Skirting", "Doors", "Beds", "Steps", "Spindles", 
    "Door Frames", "Window Frames"
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product | TimberTrack</title>
    <style>
        body { font-family: sans-serif; background: #fdfbf7; padding: 40px; }
        .edit-box { max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        input, select { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; }
        .save-btn { background: #8b5a2b; color: white; border: none; width: 100%; padding: 15px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="edit-box">
        <h2>Edit Product Details</h2>
        <form action="update_product_full.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
            
            <label>Item Name:</label>
            <input type="text" name="wood_type" value="<?php echo $p['wood_type']; ?>" required>

            <label>Category:</label>
            <select name="category">
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat; ?>" <?php if($p['product_category'] == $cat) echo 'selected'; ?>>
                        <?php echo $cat; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Price (Ksh):</label>
            <input type="number" name="price" value="<?php echo $p['price_ksh']; ?>" required>

            <label>Stock Amount:</label>
            <input type="number" name="stock" value="<?php echo $p['stock_quantity']; ?>" required>

            <button type="submit" class="save-btn">Save Changes</button>
            <p style="text-align:center;"><a href="admin_dashboard.php" style="color:#666;">Cancel</a></p>
        </form>
    </div>
</body>
</html>