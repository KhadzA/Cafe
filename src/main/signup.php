<?php
require 'dbase/db.php'; 

$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; 
    $email = $_POST['email'];
    $role = 'guest'; 

    // Check if the passwords match
    if ($password !== $confirm_password) {
        $errorMessage = "Passwords do not match!";
    } else {
        // Check if the username already exists
        $sqlCheck = "SELECT * FROM users WHERE username = :username";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute([':username' => $username]);
        $existingUser = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            $errorMessage = "Username already taken. Please choose another username.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the SQL statement to insert the new user
            $sql = "INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)";

            try {
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':username' => $username,
                    ':password' => $hashedPassword,
                    ':email' => $email,
                    ':role' => $role
                ]);

                header("Location: /login");
                exit();

            } catch (PDOException $e) {
                $errorMessage = "Error: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
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

        <?php if ($errorMessage): ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" class="TextInput" name="username" placeholder="Username" required>
            <input type="email" class="TextInput" name="email" placeholder="Email" required>
            <input type="password" class="TextInput" name="password" placeholder="Password" required>
            <input type="password" class="TextInput" name="confirm_password" placeholder="Confirm Password" required>

            <button type="submit" class="signup-btn">Create account</button>
        </form>

        <p class="toLogin">
            <span class="continue-as">Already have an account?</span>
            <a href="/login" class="guest">Login now</a>
        </p>
    </div>
</body>
</html>
