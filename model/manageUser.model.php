<?php
require_once __DIR__ . '../../connection/database.php';

class ManageUserModel extends dBase {

    public function __construct() {
    
    }

    // Retrieve all users from the database
    public function getAllUsers() {
        $sql = "SELECT user_id, username, email, role FROM users";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($userId) {
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Update the username and password of a user by ID
    public function updateUser($userId, $newUsername, $newPassword = null) {
        $sql = "UPDATE users SET username = :username";

        if ($newPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $sql .= ", password = :password";
        }

        $sql .= " WHERE user_id = :user_id";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':username', $newUsername, PDO::PARAM_STR);
        
        if ($newPassword) {
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        }

        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Update the password of a user by ID
    public function updatePassword($userId, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET password = :password WHERE user_id = :user_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
