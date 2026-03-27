<?php
session_start();
include("../config/db.php");

// Check login FIRST
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// REMOVE item
if (isset($_POST['remove'])) {
    $product_id = $_POST['product_id'];
    $conn->query("DELETE FROM cart WHERE user_id='$user_id' AND product_id='$product_id'");
}

// ADD to cart
if (isset($_POST['add_to_cart'])) {

    $product_id = $_POST['product_id'];

    $check = $conn->query("SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id'");

    if ($check->num_rows > 0) {
        $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE user_id='$user_id' AND product_id='$product_id'");
    } else {
        $conn->query("INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', 1)");
    }

    echo "Added to cart!";
}

// CHECKOUT
if (isset($_POST['checkout'])) {

    $result = $conn->query("
        SELECT products.price, cart.quantity 
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = '$user_id'
    ");

    $total = 0;

    while($row = $result->fetch_assoc()) {
        $total += $row['price'] * $row['quantity'];
    }

    $conn->query("INSERT INTO orders (user_id, total_price) VALUES ('$user_id', '$total')");
    $conn->query("DELETE FROM cart WHERE user_id='$user_id'");

    echo "Order placed successfully!";
}

// FETCH CART
$result = $conn->query("
    SELECT products.*, cart.quantity 
    FROM cart 
    JOIN products ON cart.product_id = products.id 
    WHERE cart.user_id = '$user_id'
");

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
</head>
<body>
    <link rel="stylesheet" href="/ecommerce/assets/css/style.css">
    <?php include("../includes/navbar.php"); ?>

<h2>Your Cart 🛒</h2>

<a href="home.php">Back to shop</a><br><br>

<?php while($row = $result->fetch_assoc()) { ?>

    <div style="border:1px solid black; padding:10px; margin:10px;">
        <img src="/ecommerce/assets/images/<?php echo $row['image']; ?>" width="100"><br>
        <h4><?php echo $row['name']; ?></h4>
        <p>Price: <?php echo $row['price']; ?> $</p>
        <p>Quantity: <?php echo $row['quantity']; ?></p>
    </div>

    <?php $total += $row['price'] * $row['quantity']; ?>

    <form method="POST">
        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
        <button name="remove">Remove</button>
    </form>

<?php } ?>

<h3>Total: <?php echo $total; ?> $</h3>

<form method="POST">
    <button name="checkout">Checkout</button>
</form>

</body>
</html>