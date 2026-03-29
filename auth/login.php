<?php
session_start();
include("../config/db.php");

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {

            // Store session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];

            if ($user['is_admin'] == 1) {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../user/home.php");
            }
            exit();

            // Redirect later (we will add it after)
        } else {
            echo "Wrong password!";
        }

    } else {
        echo "User not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="/eshop/assets/css/style.css">
</head>
<body>

<div class="form-container">
    <div class="form-card">
        <h2>Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button name="login">Login</button>
        </form>
        <p>Don't have an account? <a href="/eshop/auth/register.php">Register here</a></p>
    </div>
</div>

</body>
</html>