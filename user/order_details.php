<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$order_id = $_GET['id'];

// Get order items with product info
$result = $conn->query("
    SELECT products.name, products.price, products.image, order_items.quantity
    FROM order_items
    JOIN products ON order_items.product_id = products.id
    WHERE order_items.order_id = '$order_id'
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <link rel="stylesheet" href="/eshop/assets/css/style.css">
</head>
<body>

<?php include("../includes/navbar.php"); ?>

<h2>Order Details 📦</h2>

<?php while($row = $result->fetch_assoc()) { ?>

    <div class="product">
        <img src="/eshop/assets/images/<?php echo $row['image']; ?>">
        <h4><?php echo $row['name']; ?></h4>
        <p>Price: <?php echo $row['price']; ?> $</p>
        <p>Quantity: <?php echo $row['quantity']; ?></p>
    </div>

<?php } ?>

</body>
</html>