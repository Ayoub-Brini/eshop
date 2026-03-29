<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user orders
$result = $conn->query("SELECT * FROM orders WHERE user_id='$user_id' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <link rel="stylesheet" href="/eshop/assets/css/style.css">
</head>
<body>

<?php include("../includes/navbar.php"); ?>

<h2>My Orders 🧾</h2>

<?php while($row = $result->fetch_assoc()) { ?>

    <div class="product">
        <h4>
    <a href="order_details.php?id=<?php echo $row['id']; ?>">
        Order #<?php echo $row['id']; ?>
    </a>
</h4>
        <p>Total: <?php echo $row['total_price']; ?> $</p>
        <p>Date: <?php echo $row['created_at']; ?></p>
    </div>

<?php } ?>

</body>
</html>