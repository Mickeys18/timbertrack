<?php
include('db_connect.php');

// 1. SEARCH LOGIC
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search']);
}

// 2. SQL QUERY
if ($search_query != "") {
    $sql = "SELECT * FROM products WHERE 
            wood_type LIKE '%$search_query%' OR 
            product_category LIKE '%$search_query%' 
            ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM products ORDER BY id DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Timber Catalog | Available Products</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #fdfbf7; margin: 0; padding: 20px; color: #3e2723; }
        .header { text-align: center; margin-bottom: 30px; }
        
        .search-container { display: flex; justify-content: center; margin-bottom: 40px; width: 100%; }
        .search-box { background: white; padding: 15px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; gap: 10px; width: 100%; max-width: 600px; }
        .search-box input { flex: 1; padding: 12px; border: 2px solid #efebe9; border-radius: 8px; outline: none; font-size: 1rem; }
        .search-box button { padding: 12px 25px; background: #8b5a2b; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; }

        .catalog-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; max-width: 1100px; margin: 0 auto; }
        .product-card { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-top: 5px solid #8b5a2b; position: relative; }
        
        /* Stock Badge Styles */
        .badge { padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase; margin-bottom: 10px; display: inline-block; }
        .instock { background: #e8f5e9; color: #2e7d32; }
        .lowstock { background: #fff3e0; color: #ef6c00; }
        .outofstock { background: #ffebee; color: #c62828; }

        .price { font-size: 1.2rem; color: #5c4033; font-weight: bold; margin: 10px 0; }
        .unit-text { font-size: 0.85rem; color: #777; font-weight: normal; }
        
        /* Booking Button Styles */
        .book-btn { display: inline-block; background: #3e2723; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-weight: bold; text-align: center; width: 100%; box-sizing: border-box; }
        .disabled-btn { background: #ccc !important; color: #666 !important; cursor: not-allowed; pointer-events: none; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Available Products</h1>
        <p>Quality Timber from the Coast to your Doorstep</p>
    </div>

    <div class="search-container">
        <form action="customer_catalog.php" method="GET" class="search-box">
            <input type="text" name="search" placeholder="Search timber types..." value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="catalog-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <?php 
                        // --- LIVE STOCK LOGIC ---
                        $qty = $row['stock_quantity'];
                        $cat = strtolower($row['product_category']);
                        $is_feet = (strpos($cat, 'timber') !== false || strpos($cat, 'cladding') !== false);
                        $unit = $is_feet ? "ft" : "pcs";

                        // Define thresholds
                        if ($qty <= 0) {
                            $display_status = "Out of Stock";
                            $badge_class = "outofstock";
                        } elseif (($is_feet && $qty < 100) || (!$is_feet && $qty < 50)) {
                            $display_status = "Low Stock";
                            $badge_class = "lowstock";
                        } else {
                            $display_status = "In Stock";
                            $badge_class = "instock";
                        }
                    ?>
                    
                    <span class="badge <?php echo $badge_class; ?>"><?php echo $display_status; ?></span>

                    <h3 style="margin: 5px 0;"><?php echo $row['wood_type']; ?></h3>
                    <p style="color: #888; margin-bottom: 5px;"><?php echo $row['product_category']; ?></p>
                    
                    <div class="price">
                        KES <?php echo number_format($row['price_ksh'], 2); ?> 
                        <span class="unit-text">/<?php echo $unit; ?></span>
                    </div>

                    <p style="font-size: 0.9rem; margin-bottom: 15px;">
                        Available: <strong><?php echo $qty; ?> <?php echo $unit; ?></strong>
                    </p>

                    <?php if ($display_status == 'Out of Stock'): ?>
                        <a href="#" class="book-btn disabled-btn">Unavailable</a>
                    <?php else: ?>
                        <a href="booking_form.php?id=<?php echo $row['id']; ?>" class="book-btn">Book Now →</a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                <h3>No products found.</h3>
                <a href="customer_catalog.php" style="color: #8b5a2b;">Refresh Catalog</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>