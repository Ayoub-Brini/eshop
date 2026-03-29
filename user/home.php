<?php
session_start();
include("../config/db.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Get products
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    $result = $conn->query("
        SELECT * FROM products 
        WHERE name LIKE '%$search%'
    ");

} else if (isset($_GET['category'])) {

    $category_id = $_GET['category'];

    $result = $conn->query("
        SELECT * FROM products 
        WHERE category_id = '$category_id'
    ");

} else {
    $result = $conn->query("SELECT * FROM products");
}

// Get categories
$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="/eshop/assets/css/style.css">
</head>

<body>

<?php include("../includes/navbar.php"); ?>

<h2>Welcome <?php echo $_SESSION['username']; ?> </h2>

<!-- CATEGORIES -->
<div class="categories">
<?php while($cat = $categories->fetch_assoc()) { ?>
    <a class="category" href="?category=<?php echo $cat['id']; ?>">
        <?php echo $cat['name']; ?>
    </a>
<?php } ?>
</div>

<!-- SEARCH -->
<div class="container">
    <form method="GET">
        <input type="text" name="search" placeholder="Search products...">
        <button type="submit">Search</button>
    </form>
</div>

<h3 style="text-align:center;">Products:</h3>

<!-- PRODUCTS -->
<div class="container">

<?php while($row = $result->fetch_assoc()) { ?>

    <div class="product">
        <img src="/eshop/assets/images/<?php echo $row['image']; ?>">

        <h4><?php echo $row['name']; ?></h4>

        <p><?php echo $row['price']; ?> $</p>

        <form method="POST" action="cart.php">
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
            <button name="add_to_cart">Add to Cart</button>
        </form>
    </div>

<?php } ?>

</div>

</body>
</html>