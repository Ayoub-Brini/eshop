<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>

<h2>Welcome <?php echo $_SESSION['username']; ?> 👋</h2>

<a href="../auth/logout.php">Logout</a>

</body>
</html>