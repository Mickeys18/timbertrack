<?php
include('db_connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | TimberTrack Kenya</title>
    <style>
        :root {
            --primary-brown: #8b5a2b;
            --dark-brown: #3e2723;
            --bg-cream: #fdfbf7;
        }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: var(--bg-cream); 
            margin: 0; 
            color: var(--dark-brown); 
        }

        /* Hero Section */
        .hero { 
            text-align: center; 
            padding: 80px 20px; 
            background: white; 
            border-bottom: 5px solid var(--primary-brown);
        }
        .hero h1 { font-size: 2.5rem; margin-bottom: 10px; }
        .hero p { font-size: 1.1rem; color: #666; }

        /* Main Portals */
        .portal-container { 
            max-width: 1000px; 
            margin: -50px auto 40px auto; 
            display: flex; 
            justify-content: center; 
            gap: 30px; 
            padding: 0 20px;
        }
        .portal-card { 
            background: white; 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
            border: 1px solid #efebe9; 
            flex: 1; 
            text-align: center;
            max-width: 450px;
        }
        .portal-card h2 { color: var(--primary-brown); margin-top: 0; }
        
        .btn { 
            display: inline-block; 
            padding: 12px 35px; 
            background: var(--primary-brown); 
            color: white; 
            text-decoration: none; 
            border-radius: 8px; 
            font-weight: bold; 
            margin-top: 20px;
            transition: 0.3s;
        }
        .btn:hover { background: var(--dark-brown); }
        .btn-staff { background: var(--dark-brown); }

        /* Track Order Section */
        .track-section { 
            background: #efebe9; 
            padding: 60px 20px; 
            text-align: center; 
        }
        .track-form { margin-top: 20px; }
        .track-input { 
            padding: 15px; 
            border: 1px solid #ccc; 
            border-radius: 8px; 
            width: 300px; 
            font-size: 1rem;
            outline: none;
        }
        .track-btn {
            background: var(--primary-brown);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            margin-left: 10px;
        }
    </style>
</head>
<body>

    <div class="hero">
        <h1>Welcome to Timber Catalog Kenya</h1>
        <p>Premium Cypress, Pine, Mahogany Inventory Management</p>
    </div>

    <div class="portal-container">
        <div class="portal-card">
            <h2>Customer Portal</h2>
            <p>Browse our current stock, view prices, and book your timber orders online.</p>
            <a href="customer_catalog.php" class="btn">Enter Catalog</a>
        </div>

        <div class="portal-card">
            <h2>Staff Portal</h2>
            <p>Manage wood inventory, confirm payments, and generate customer receipts.</p>
            <a href="admin_login.php" class="btn btn-staff">Staff Login</a>
        </div>
    </div>

    <div class="track-section">
        <h2>Track Your Order</h2>
        <p>Checking on a booking? Enter your unique <strong>TMB</strong> code below.</p>
        <form action="track_order.php" method="POST" class="track-form">
            <input type="text" name="tracking_code" placeholder="e.g., TMB-8492" class="track-input" required>
            <button type="submit" class="track-btn">Track Status</button>
        </form>
    </div>

    <footer style="text-align: center; padding: 40px; color: #888; font-size: 0.9rem;">
        &copy; 2026 TimberTrack Kenya - TUM IT Architecture Project
    </footer>

</body>
</html>