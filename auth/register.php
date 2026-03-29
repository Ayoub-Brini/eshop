<?php
include("../config/db.php");

if (isset($_POST['register'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email exists
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");

    if ($check->num_rows > 0) {
        echo "Email already exists!";
    } else {

        $sql = "INSERT INTO users (username, email, password) 
                VALUES ('$username', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "User registered successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="/eshop/assets/css/style.css">
</head>
<body>

<div class="form-container">
    <div class="form-card">
        <h2>Create an account</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register">Sign Up</button>
        </form>
        <p>Already have an account? <a href="/eshop/auth/login.php">Login here</a></p>
    </div>
</div>

</body>
</html>