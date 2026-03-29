<?php
include("../config/db.php");

// TOTAL PRODUCTS
$products = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];

// TOTAL ORDERS
$orders = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()['total'];

// TOTAL USERS
$users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];

// TOTAL REVENUE
$revenue = $conn->query("SELECT SUM(total_price) as total FROM orders")->fetch_assoc()['total'];
$revenue = $revenue ? $revenue : 0;
?>
<?php
session_start();

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Check admin
if ($_SESSION['is_admin'] != 1) {
    echo "Access denied!";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <link rel="stylesheet" href="/eshop/assets/css/style.css">
    <?php include("../includes/navbar.php"); ?>
<h2>Admin Dashboard 🛠️</h2>

<div class="dashboard">

    <div class="card stat">
        <h3>📦 Products</h3>
        <p><?php echo $products; ?></p>
    </div>

    <div class="card stat">
        <h3>🛒 Orders</h3>
        <p><?php echo $orders; ?></p>
    </div>

    <div class="card stat">
        <h3>👥 Users</h3>
        <p><?php echo $users; ?></p>
    </div>

    <div class="card stat">
        <h3>💰 Revenue</h3>
        <p><?php echo $revenue; ?> $</p>
    </div>

</div>

<div class="admin-actions">
    <a href="manage_products.php" class="admin-btn">📦 Manage Products</a>
</div>



</body>
</html>