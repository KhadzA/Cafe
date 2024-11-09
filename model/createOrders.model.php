<?php

require_once __DIR__ . '../../connection/database.php';

class CreateOrdersModel extends dBase {
    
    public function __construct() {
    
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



}