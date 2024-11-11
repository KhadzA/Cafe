<?php

require_once __DIR__ . '../../model/orders.model.php';

class OrdersCtrl extends OrdersModel {

    public function handleRequest() {
        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'update_order_status':
                $this->updateOrderStatus($_POST['order_id'], $_POST['status']);
                break;

            case 'delete_order':
                $this->deleteOrder($_POST['order_id']);
                break;

            default:
                $this->redirectTo404();
                break;
        }
    }
    
    public function getOrders() {
        return $this->getAllOrders();
    }



    //Redirect
    private function redirectTo404() {
        header("Location: ../../pages/404.php");
        exit();
    }
}
