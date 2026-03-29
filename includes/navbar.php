<?php
include("../config/db.php");

$user_id = $_SESSION['user_id'];

// Count total items in cart
$count_query = $conn->query("
    SELECT SUM(quantity) as total 
    FROM cart 
    WHERE user_id = '$user_id'
");

$count_result = $count_query->fetch_assoc();
$cart_count = $count_result['total'] ? $count_result['total'] : 0;
?>

<?php ?>

<div class="navbar">

    <div class="nav-left">
        <a href="/eshop/user/home.php">Home</a>
        <a href="/eshop/user/cart.php" class="cart-link">
    Cart
    <?php if ($cart_count > 0) { ?>
        <span class="cart-badge"><?php echo $cart_count; ?></span>
    <?php } ?>
</a>
        <a href="/eshop/user/orders.php">Orders</a>

        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) { ?>
            <a href="/eshop/admin/dashboard.php" class="admin-link">Admin</a>
        <?php } ?>
    </div>

    <div class="nav-right">
        <span class="username"><?php echo $_SESSION['username']; ?></span>
        <a href="/eshop/auth/logout.php" class="logout">Logout</a>
    </div>

</div>