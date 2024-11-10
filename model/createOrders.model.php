<?php

require_once __DIR__ . '../../connection/database.php';

class CreateOrdersModel extends dBase {

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

    public function getProductsById() {
        
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

    

    //CART
    public function addOrder($userId, $totalAmount) {
        $sql = "INSERT INTO orders (user_id, total_amount) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId, $totalAmount]);
        return $this->conn->lastInsertId();
    }



    public function addOrderItem($orderId, $productId, $userId, $quantity, $sizeId = null, $sugarLevelId = null, $price) {
        $sql = "INSERT INTO order_items (order_id, product_id, user_id, quantity, size_id, sugar_level_id, price) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        
        // Bind parameters, including NULL for optional fields if they are not set
        $stmt->bindValue(1, $orderId, PDO::PARAM_INT);
        $stmt->bindValue(2, $productId, PDO::PARAM_INT);
        $stmt->bindValue(3, $userId, PDO::PARAM_INT);
        $stmt->bindValue(4, $quantity, PDO::PARAM_INT);
        $stmt->bindValue(5, $sizeId, $sizeId !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
        $stmt->bindValue(6, $sugarLevelId, $sugarLevelId !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
        $stmt->bindValue(7, $price, PDO::PARAM_STR);

        $stmt->execute();
    }




}