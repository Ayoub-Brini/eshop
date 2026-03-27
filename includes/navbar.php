<?php session_start(); ?>

<div style="background:black; padding:10px; color:white;">

    <a href="/ecommerce/user/home.php" style="color:white; margin-right:15px;">Home</a>

    <a href="/ecommerce/user/cart.php" style="color:white; margin-right:15px;">Cart</a>

    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) { ?>
        <a href="/ecommerce/admin/dashboard.php" style="color:white; margin-right:15px;">Admin</a>
    <?php } ?>

    <span style="float:right;">
        <?php echo $_SESSION['username']; ?> |
        <a href="/ecommerce/auth/logout.php" style="color:white;">Logout</a>
    </span>

</div>