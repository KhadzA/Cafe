<?php

session_start();

class Login extends dBase {

    protected function getUser($username) {
        $sql = 'SELECT user_id, username, password, role FROM users WHERE username = ? OR email = ?;';
        $stmt = $this->connect()->prepare($sql);

        if (!$stmt->execute(array($username, $username))) {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            return null; 
        }

        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function login($username, $password) {
        $user = $this->getUser($username);

        if ($user) {
            if (password_verify($password, $user["password"])) {
                session_name($user["role"] . $user["user_id"]);
                // session_start();

                // Set session variables
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["role"] = $user["role"];

                // Redirect based on user role
                if ($user["role"] === 'admin') {
                    header("Location: ../AdminDashboard");
                } 
                elseif ($user["role"] === 'cashier') {
                    header("Location: ../cashier");
                }
                exit();
            } else {
                header("location: ../index.php?error=wrongpassword");
                exit();
            }
        } else {
            header("location: ../index.php?error=usernotfound");
            exit();
        }
    }
}