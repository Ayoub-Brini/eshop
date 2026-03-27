<?php
session_start();
include("../config/db.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Get products from database
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <link rel="stylesheet" href="/ecommerce/assets/css/style.css">
    <?php include("../includes/navbar.php"); ?>

<h2>Welcome <?php echo $_SESSION['username']; ?> 👋</h2>

<a href="../auth/logout.php">Logout</a>

<h3>Products:</h3>

<?php while($row = $result->fetch_assoc()) { ?>
    
   <div class="product">
    <img src="/ecommerce/assets/images/<?php echo $row['image']; ?>">

    <h4><?php echo $row['name']; ?></h4>

    <p><?php echo $row['price']; ?> $</p>

    <form method="POST" action="cart.php">
        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
        <button name="add_to_cart">Add to Cart</button>
    </form>
</div>

<?php } ?>

</body>
</html>