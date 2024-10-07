<?php
require 'dbase/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        echo "Login successful! Welcome, " . $_SESSION['username'];
        // Redirect to dashboard or other page
        header("Location: /dashBoard");
        exit;
    } else {
        echo "Invalid username or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../src/styles/authStyle.css">
</head>

<body>

    <div class="back">
        <a href="/" class="logout-button">
            <img src="../src/img/back.png" alt="Logout" class="logout-icon">
        </a>
    </div>

    <div class="container">
        <div class="logo">
            <img src="../src/img/Cafe_Logo.png" alt="Logo">
        </div>

        <form method="POST" action=""> 
            <input type="text" class="TextInput" name="username" placeholder="Username" required>
            <input type="password" class="TextInput" name="password" placeholder="Password" required>

            <button type="submit" class="login-btn">Login</button>
        </form>

        <p class="toSignUp-text">
            <span class="continue-as">Don't have an account?</span>
            <a href="/signup" class="guest">Register</a>
        </p>
    </div>
</body>

</html>
