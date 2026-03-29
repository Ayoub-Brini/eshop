<?php ?>

<div style="background:black; padding:10px; color:white;">

    <a href="/eshop/user/home.php" style="color:white; margin-right:15px;">Home</a>

    <a href="/eshop/user/cart.php" style="color:white; margin-right:15px;">Cart</a>
    <a href="/eshop/user/orders.php" style="color:white; margin-right:15px;">Orders</a>
    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) { ?>
        <a href="/eshop/admin/dashboard.php" style="color:white; margin-right:15px;">Admin</a>
    <?php } ?>

    <span style="float:right;">
        <?php echo $_SESSION['username']; ?> |
        <a href="/eshop/auth/logout.php" style="color:white;">Logout</a>
    </span>

</div>