<?php

class Signup extends dBase {

    protected function setUser($username, $email, $password) {
        $sql = 'INSERT INTO users (username, email, password) VALUES (?, ?, ?);';
        $stmt = $this->connect()->prepare($sql);

        $hashedPass = password_hash($password, PASSWORD_DEFAULT);

        if (!$stmt->execute(array($username, $email, $hashedPass))) {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }

    protected function checkUser($username, $email) {
        $sql = 'SELECT username FROM users WHERE username = ? OR email = ?;';
        $stmt = $this->connect()->prepare($sql);

        if (!$stmt->execute(array($username, $email))) {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        return $stmt->rowCount() == 0;
    }
}
