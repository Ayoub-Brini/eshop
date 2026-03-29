<?php
session_start();
include("../config/db.php");

// Check admin
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    echo "Access denied!";
    exit();
}

// DELETE product
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id='$id'");
    header("Location: manage_products.php");
    exit();
}

$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <link rel="stylesheet" href="/eshop/assets/css/style.css">
</head>
<body>

<?php include("../includes/navbar.php"); ?>

<h2>Manage Products</h2>

<a href="add_product.php" style="background:green; color:white; padding:10px; text-decoration:none; border-radius:5px;">+ Add New Product</a>

<br><br>

<?php while($row = $result->fetch_assoc()) { ?>

    <div class="product">
        <img src="/eshop/assets/images/<?php echo $row['image']; ?>">

        <h4><?php echo $row['name']; ?></h4>
        <p><?php echo $row['price']; ?> $</p>

        <a href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a><br>
        <a href="manage_products.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this product?')">Delete</a>
    </div>

<?php } ?>

</body>
</html>