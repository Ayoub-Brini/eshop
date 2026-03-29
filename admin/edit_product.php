<?php
session_start();
include("../config/db.php");

// Check admin
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    echo "Access denied!";
    exit();
}

$id = $_GET['id'];

// Get product data
$result = $conn->query("SELECT * FROM products WHERE id='$id'");
$product = $result->fetch_assoc();

// Update product
if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];

    $conn->query("UPDATE products SET name='$name', price='$price' WHERE id='$id'");

    header("Location: manage_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="/eshop/assets/css/style.css">
</head>
<body>

<div class="form-container">
    <div class="form-card">
        <h2>Edit Product</h2>
        <form method="POST">
            <input type="text" name="name" value="<?php echo $product['name']; ?>" placeholder="Product Name" required>
            <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" placeholder="Price" required>
            <button name="update">Update Product</button>
        </form>
        <p><a href="manage_products.php">Back to Products</a></p>
    </div>
</div>

</body>
</html>