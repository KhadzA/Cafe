<?php
require_once __DIR__ . '../../model/manageUser.model.php';

class ManageUserCtrl extends ManageUserModel {

    public function handleRequest() {
        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'delete_user':
                $this->deleteUserHandler();
                break;
            case 'update_user':
                $this->updateUserHandler();
                break;
            case 'update_password':
                $this->updatePasswordHandler();
                break;
            default:
                $this->redirectTo404();
                break;
        }
    }

    public function getUsers() {
        return $this->getAllUsers();
    }

    private function deleteUserHandler() {
        $userId = $_POST['user_id'] ?? null;
        $success = $userId && $this->deleteUser($userId);
        echo json_encode(['success' => $success]);
        exit();
    }

    private function updateUserHandler() {
        $userId = $_POST['user_id'] ?? null;
        $newUsername = $_POST['username'] ?? '';
        $newPassword = $_POST['password'] ?? '';

        if ($userId && $newUsername && $this->updateUser($userId, $newUsername, $newPassword)) {
            echo json_encode(['success' => true, 'message' => 'User updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating user']);
        }
        exit();
    }

    private function updatePasswordHandler() {
        $userId = $_POST['user_id'] ?? null;
        $newPassword = $_POST['new_password'] ?? '';
        
        if ($userId && $newPassword && $this->updatePassword($userId, $newPassword)) {
            echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating password']);
        }
        exit();
    }

    private function redirectTo404() {
        header("Location: ../../pages/404.php");
        exit();
    }
}
