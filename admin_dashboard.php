<?php
session_start();
include('db_connect.php');

// 1. SECURITY: Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// 2. STOCK LOGIC FUNCTION
function getStockStatus($quantity, $category) {
    if ($quantity <= 0) return "Out of Stock";
    
    $cat = strtolower($category);
    // Feet-based items: Timber, Cladding, Leaping, Boards, Skirting
    $is_feet = strpos($cat, 'timber') !== false || strpos($cat, 'cladding') !== false || 
               strpos($cat, 'leaping') !== false || strpos($cat, 'board') !== false || 
               strpos($cat, 'skirting') !== false;

    if ($is_feet) {
        return ($quantity < 100) ? "Low Stock" : "In Stock";
    } 
    // Piece-based items: Doors, Beds, Steps, Spindles
    return ($quantity < 50) ? "Low Stock" : "In Stock";
}

// 3. FETCH COUNTS FOR THE ALERT BANNERS
$out_count_res = $conn->query("SELECT COUNT(*) as total FROM products WHERE stock_quantity <= 0");
$out_count = $out_count_res->fetch_assoc()['total'];

$low_count = 0;
$counter_query = $conn->query("SELECT stock_quantity, product_category FROM products");
while($p = $counter_query->fetch_assoc()) {
    $status = getStockStatus($p['stock_quantity'], $p['product_category']);
    if ($status == "Low Stock") {
        $low_count++;
    }
}

// 4. FETCH ALL PRODUCTS FOR THE TABLE
$sql = "SELECT * FROM products ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory | TimberTrack Kenya</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #fdfbf7; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        
        .nav-links { background: #efebe9; padding: 15px; border-radius: 8px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; }
        .nav-links a { text-decoration: none; color: #3e2723; font-weight: bold; margin-right: 20px; }
        .btn-add { background: #2e7d32; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; }

        /* Alert Box Styles */
        .alert-container { display: flex; gap: 15px; margin-bottom: 25px; }
        .alert-box { flex: 1; padding: 15px; border-radius: 8px; display: flex; align-items: center; gap: 12px; border-left: 5px solid; }
        .critical { background: #ffebee; border-color: #c62828; color: #b71c1c; }
        .warning { background: #fff3e0; border-color: #ef6c00; color: #e65100; }
        .healthy { background: #e8f5e9; border-color: #2e7d32; color: #1b5e20; width: 100%; }

        table { width: 100%; border-collapse: collapse; }
        th { background: #8b5a2b; color: white; padding: 15px; text-align: left; }
        td { padding: 15px; border-bottom: 1px solid #eee; }
        
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; }
        .instock { background: #e8f5e9; color: #2e7d32; }
        .lowstock { background: #fff3e0; color: #ef6c00; }
        .outofstock { background: #ffebee; color: #c62828; }
        
        .btn-edit { background: #007bff; color: white; padding: 8px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; }
    </style>
</head>
<body>

<div class="container">
    <div class="nav-links">
        <div>
            <a href="admin_inventory.php">🏠 BACK TO DASHBOARD</a>
            <a href="admin_bookings.php">📋 MANAGE ORDERS</a>
        </div>
        <a href="add_product.php" class="btn-add">+ ADD NEW ITEM</a>
    </div>

    <h1>Timber Inventory Management</h1>
    <p style="color: #6d4c41; margin-bottom: 25px;">Live monitoring of stock levels in Mombasa Yard.</p>

    <div class="alert-container">
        <?php if($out_count > 0): ?>
            <div class="alert-box critical">
                <span style="font-size: 1.5rem;">🚨</span>
                <div><strong>OUT OF STOCK:</strong> <?php echo $out_count; ?> items are empty.</div>
            </div>
        <?php endif; ?>

        <?php if($low_count > 0): ?>
            <div class="alert-box warning">
                <span style="font-size: 1.5rem;">⚠️</span>
                <div><strong>LOW STOCK:</strong> <?php echo $low_count; ?> items need restocking.</div>
            </div>
        <?php endif; ?>

        <?php if($out_count == 0 && $low_count == 0): ?>
            <div class="alert-box healthy">
                <strong>✅ ALL SYSTEMS GREEN:</strong> Stock levels are currently healthy.
            </div>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Category</th>
                <th>Price (Ksh)</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <?php 
                    $status = getStockStatus($row['stock_quantity'], $row['product_category']);
                    $badge_class = str_replace(' ', '', strtolower($status));
                    
                    // Unit Detection
                    $cat_lower = strtolower($row['product_category']);
                    $unit = (strpos($cat_lower, 'timber') !== false || strpos($cat_lower, 'cladding') !== false || 
                             strpos($cat_lower, 'board') !== false || strpos($cat_lower, 'leaping') !== false) ? "ft" : "pcs";
                ?>
                <tr>
                    <td><strong><?php echo $row['wood_type']; ?></strong></td>
                    <td><?php echo $row['product_category']; ?></td>
                    <td>Ksh <?php echo number_format($row['price_ksh'], 2); ?></td>
                    <td><?php echo $row['stock_quantity']; ?> <small style="color: #999;"><?php echo $unit; ?></small></td>
                    <td><span class="badge <?php echo $badge_class; ?>"><?php echo $status; ?></span></td>
                    <td>
                        <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit Details</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>