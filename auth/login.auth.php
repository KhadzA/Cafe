<?php
// session_start();

if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    // session_name('admin_session');
    header("Location: ../AdminDashboard");
} 
elseif (isset($_SESSION['user_id']) && $_SESSION['role'] === 'cashier') {
    // session_name('employee_session');
    header("Location: ../cashier");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/script.js"></script>

    <link rel="icon" href="../image/Cafe_Logo.png" type="image/icon type">
    <link rel="stylesheet" href="../css/authStyle.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="../image/Cafe_Logo.png" alt="Logo">
        </div>
        <form action="../view/login.view.php" method="POST">
            <input type="text" class="TextInput" name="username" placeholder="Username" required>
            <input type="password" class="TextInput" name="password" placeholder="Password" required>
            <button type="submit" name="submit" class="login-btn">Login</button>
        </form>
        <p class="toSignUp-text">
            <span class="continue-as">Don't have an account?</span>
            <a id="signup" class="guest">Register</a>
        </p>
    </div>
</body>
</html>

