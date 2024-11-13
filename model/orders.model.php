<?php

require_once __DIR__ . '../../connection/database.php';

class OrdersModel extends dBase {

    public function __construct() {
    }

    // public function getAllOrders() {
    //     $sql = "SELECT order_id, order_date, total_amount FROM orders ORDER BY order_date DESC";
    //     $stmt = $this->connect()->prepare($sql);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function getAllOrders() {
        $sql = "SELECT order_id, order_date, total_amount 
                FROM orders 
                WHERE order_id NOT IN (SELECT order_id FROM history)
                ORDER BY order_date DESC";
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


    public function getOrderDetails($order_id) {
        $sql = "SELECT order_id, order_date, total_amount, status FROM orders WHERE order_id = :order_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderItemsByOrderId($order_id) {
        $sql = "
            SELECT 
                oi.order_item_id, 
                oi.product_id, 
                oi.quantity, 
                oi.size_id, 
                oi.sugar_level_id, 
                oi.price AS amount, 
                p.product_name,
                ps.size AS size,
                psl.sugar_level AS sugar_level
            FROM order_items oi
            JOIN product p ON oi.product_id = p.product_id
            LEFT JOIN product_size ps ON oi.size_id = ps.size_id
            LEFT JOIN product_sugar_level psl ON oi.sugar_level_id = psl.sugar_level_id
            WHERE oi.order_id = :order_id
        ";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    function getOrderItems($orderId) {
        global $db;
        $stmt = $db->prepare("SELECT oi.quantity, p.product_name, ps.size, oi.price AS amount
                            FROM order_items oi
                            JOIN product p ON oi.product_id = p.product_id
                            LEFT JOIN product_size ps ON oi.size_id = ps.size_id
                            WHERE oi.order_id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markOrderAsHistory($orderId) {
        $sql = "INSERT INTO history (order_id) VALUES (:order_id)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getHistoryOrders() {
        $sql = "SELECT orders.order_id, orders.order_date, orders.total_amount
                FROM orders
                INNER JOIN history ON orders.order_id = history.order_id
                ORDER BY history.archived_at DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
