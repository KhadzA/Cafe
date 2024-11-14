<?php

require_once __DIR__ . '../../connection/database.php';

class CashierModel extends dBase {

    private $conn;
    
    public function __construct() {
        $this->conn = $this->connect();
    }


    //CATEGORIES
    public function getCategories() {
        $sql = "SELECT * FROM category";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryById($categoryId) {
        $sql = "SELECT * FROM category WHERE category_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }




    //PRODUCTS
    public function getProductsByCategory($category_id) {
        $sql = "SELECT p.product_id, p.product_name, p.description, p.image, 
                    ps.size, psl.sugar_level, ps.price_modifier, p.price AS base_price
                FROM product p
                LEFT JOIN product_size ps ON p.product_id = ps.product_id
                LEFT JOIN product_sugar_level psl ON p.product_id = psl.product_id
                WHERE p.category_id = ?";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$category_id]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Combine size and sugar level into a new field for easy display
        foreach ($products as &$product) {
            $product['size_sugar_combination'] = $product['size'] . " " . $product['sugar_level'];
        }

        return $products;
    }


    public function getAllProducts() {
        $sql = "SELECT p.product_id, p.product_name, p.description, p.image, 
                    ps.size, psl.sugar_level, ps.price_modifier, p.price AS base_price
                FROM product p
                LEFT JOIN product_size ps ON p.product_id = ps.product_id
                LEFT JOIN product_sugar_level psl ON p.product_id = psl.product_id
                ORDER BY p.product_name ASC";

        $stmt = $this->connect()->query($sql);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Combine size and sugar level into a new field for easy display
        foreach ($products as &$product) {
            $product['size_sugar_combination'] = $product['size'] . " " . $product['sugar_level'];
        }

        return $products;
    }



    // Fetch size_id by size name
    public function getSizeIdBySize($size) {
        $sql = "SELECT size_id FROM product_size WHERE size = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$size]);
        return $stmt->fetchColumn();
    }

    // Fetch sugar_level_id by sugar_level name
    public function getSugarLevelIdByLevel($sugarLevel) {
        $sql = "SELECT sugar_level_id FROM product_sugar_level WHERE sugar_level = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$sugarLevel]);
        return $stmt->fetchColumn();
    }

    
    public function getSizeNameById($sizeId) {
        $sql = "SELECT size FROM product_size WHERE size_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$sizeId]);
        return $stmt->fetchColumn();
    }

    public function getSugarLevelNameById($sugarLevelId) {
        $sql = "SELECT sugar_level FROM product_sugar_level WHERE sugar_level_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$sugarLevelId]);
        return $stmt->fetchColumn();
    }

    

    //CART
    public function addOrder($userId, $totalAmount) {
        $sql = "INSERT INTO orders (user_id, total_amount) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId, $totalAmount]);
        return $this->conn->lastInsertId();
    }


    public function addOrderItem($orderId, $productId, $userId, $quantity, $sizeId, $sugarLevelId, $price, $productName, $sizeName, $sugarLevelName) {
        $sql = "INSERT INTO order_items (order_id, product_id, product_name, user_id, quantity, size_id, sugar_level_id, price, size_name, sugar_level_name) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$orderId, $productId, $productName, $userId, $quantity, $sizeId, $sugarLevelId, $price, $sizeName, $sugarLevelName]);
    }

}