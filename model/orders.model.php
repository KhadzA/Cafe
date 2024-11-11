<?php

require_once __DIR__ . '../../connection/database.php';

class OrdersModel extends dBase {

    public function __construct() {
    }

    public function getAllOrders() {
        $sql = "SELECT order_id, order_date, total_amount FROM orders ORDER BY order_date DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteOrder($orderId) {
        $sql = "DELETE FROM orders WHERE order_id = :order_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateOrderStatus($orderId, $status) {
        $sql = "UPDATE orders SET status = :status WHERE order_id = :order_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
