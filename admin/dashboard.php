<?php
session_start();

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Check admin
if ($_SESSION['is_admin'] != 1) {
    echo "Access denied!";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <link rel="stylesheet" href="/eshop/assets/css/style.css">
    <?php include("../includes/navbar.php"); ?>
<h2>Admin Dashboard 🛠️</h2>

<p>Welcome Admin <?php echo $_SESSION['username']; ?></p>

<a href="../auth/logout.php">Logout</a>

</body>
</html>