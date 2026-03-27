<?php
session_start();
include("../config/db.php");

// Check admin
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    echo "Access denied!";
    exit();
}

if (isset($_POST['add_product'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];

    // Image upload
    $image_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    $folder = "../assets/images/" . $image_name;

    // Move image to folder
    move_uploaded_file($tmp_name, $folder);

    $sql = "INSERT INTO products (name, description, price, image) 
            VALUES ('$name', '$description', '$price', '$image_name')";

    if ($conn->query($sql) === TRUE) {
        echo "Product added!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>
    <link rel="stylesheet" href="/ecommerce/assets/css/style.css">


<h2>Add Product</h2>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="image" required><br><br>
    <input type="text" name="name" placeholder="Product Name" required><br><br>
    <textarea name="description" placeholder="Description"></textarea><br><br>
    <input type="number" step="0.01" name="price" placeholder="Price" required><br><br>
    
    <button type="submit" name="add_product">Add Product</button>
</form>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>