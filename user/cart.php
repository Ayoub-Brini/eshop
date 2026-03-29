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

    // Insert order
$conn->query("INSERT INTO orders (user_id, total_price) VALUES ('$user_id', '$total')");

// Get last inserted order id
$order_id = $conn->insert_id;

// Get cart items
$cart_items = $conn->query("
    SELECT * FROM cart WHERE user_id='$user_id'
");

// Insert each product into order_items
while($item = $cart_items->fetch_assoc()) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];

    $conn->query("
        INSERT INTO order_items (order_id, product_id, quantity)
        VALUES ('$order_id', '$product_id', '$quantity')
    ");
}

// Clear cart
$conn->query("DELETE FROM cart WHERE user_id='$user_id'");
    $conn->query("DELETE FROM cart WHERE user_id='$user_id'");

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
    <link rel="stylesheet" href="/eshop/assets/css/style.css">
</head>
<body>
<?php include("../includes/navbar.php"); ?>

<div class="page-heading">
    <h2>Shopping Cart</h2>
</div>

<div class="cart-page">
    <div class="cart-grid">
        <div class="cart-table-panel">
            <div class="cart-header">
                <a href="home.php" class="back-btn">← Continue shopping</a>
            </div>

            <div class="cart-table-wrapper">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()) { ?>
                        <?php $subtotal = $row['price'] * $row['quantity']; ?>
                        <tr>
                            <td>
                                <div class="cart-product">
                                    <img src="/eshop/assets/images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                                    <div>
                                        <strong><?php echo $row['name']; ?></strong>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo $row['price']; ?> $</td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo number_format($subtotal, 2); ?> $</td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                    <button name="remove">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php $total += $subtotal; ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <aside class="summary-card">
            <div class="summary-header">
                <h3>Order Summary</h3>
            </div>

            <div class="summary-row">
                <span>Subtotal:</span>
                <strong><?php echo number_format($total, 2); ?> $</strong>
            </div>
            <div class="summary-row">
                <span>Shipping:</span>
                <span>0.00 $</span>
            </div>
            <div class="summary-row">
                <span>Tax (19%):</span>
                <span><?php echo number_format($total * 0.19, 2); ?> $</span>
            </div>

            <div class="summary-total-row">
                <span>Total:</span>
                <strong><?php echo number_format($total * 1.10, 2); ?> $</strong>
            </div>

            <form method="POST" class="summary-actions">
                <button name="checkout">Proceed to Checkout</button>
            </form>
            <a href="home.php" class="back-btn summary-link">Continue Shopping</a>
        </aside>
    </div>
</div>

</body>
</html>