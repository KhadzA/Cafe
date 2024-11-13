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
                $this->markOrder($_POST['order_id']);
                break;

            case 'literal_delete_order':
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

    public function getHistory() {
        return $this->getHistoryOrders();
    }

    public function getOrderById($order_id) {
        return $this->getOrderDetails($order_id); 
    }

    public function getOrderItems($order_id) {
        return $this->getOrderItemsByOrderId($order_id); 
    }

    public function markOrder($order_id) {
        return $this->markOrderAsHistory($order_id); 
    }



    //Redirect
    private function redirectTo404() {
        header("Location: ../../pages/404.php");
        exit();
    }
}
