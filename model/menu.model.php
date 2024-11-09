<?php

require_once __DIR__ . '../../connection/database.php';

class MenuModel extends dBase {
    
    public function __construct() {
    
    }

    // CRUD Methods for Categories
    public function createCategory($name, $description, $has_size, $has_sugar_level) {
        $sql = "INSERT INTO category (category_name, description, has_size, has_sugar_level) VALUES (?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([$name, $description, $has_size, $has_sugar_level]);
    }

    public function updateCategory($categoryId, $name, $description, $has_size, $has_sugar_level) {
        $dbh = $this->connect();
        $sql = 'UPDATE category SET category_name = ?, description = ?, has_size = ?, has_sugar_level = ? WHERE category_id = ?';
        $stmt = $dbh->prepare($sql);
        return $stmt->execute([$name, $description, $has_size, $has_sugar_level, $categoryId]);
    }


    public function deleteCategory($id) {
        $dbh = $this->connect();
        $sql = 'DELETE FROM category WHERE category_id = ?';
        $stmt = $dbh->prepare($sql);
        return $stmt->execute([$id]);
    }



    // CRUD Methods for Products
    public function createProduct($name, $description, $price, $categoryId, $sizes = [], $sugarLevels = [], $imagePath = '') {
        $dbh = $this->connect();
        
        // Insert product
        $sql = 'INSERT INTO product (product_name, description, price, category_id, image) VALUES (?, ?, ?, ?, ?)';
        $stmt = $dbh->prepare($sql);
        $stmt->execute([$name, $description, $price, $categoryId, $imagePath]);
        $productId = $dbh->lastInsertId();

        // Insert sizes if available
        if (!empty($sizes)) {
            $sqlSize = 'INSERT INTO product_size (product_id, size, price_modifier) VALUES (?, ?, ?)';
            $stmtSize = $dbh->prepare($sqlSize);
            foreach ($sizes as $size) {
                $stmtSize->execute([$productId, $size['size'], $size['price_modifier']]);
            }
        }

        // Insert sugar levels if available
        if (!empty($sugarLevels)) {
            $sqlSugar = 'INSERT INTO product_sugar_level (product_id, sugar_level) VALUES (?, ?)';
            $stmtSugar = $dbh->prepare($sqlSugar);
            foreach ($sugarLevels as $sugarLevel) {
                $stmtSugar->execute([$productId, $sugarLevel]);
            }
        }

        return $productId;
    }


    public function updateProduct($productId, $name, $description, $price, $categoryId, $sizes = [], $sugarLevels = [], $imagePath = '') {
        if (empty($productId)) {
            // Log and return an error if productId is empty or invalid
            error_log("Invalid productId provided to updateProduct.");
            return false;
        }

        $dbh = $this->connect();

        // Check if product exists
        $stmtCheck = $dbh->prepare('SELECT COUNT(*) FROM product WHERE product_id = ?');
        $stmtCheck->execute([$productId]);
        if ($stmtCheck->fetchColumn() == 0) {
            error_log("Product ID $productId does not exist.");
            return false; // Product ID is invalid
        }

        // Update the main product details
        $sql = 'UPDATE product SET product_name = ?, description = ?, price = ?, category_id = ?, image = ? WHERE product_id = ?';
        $stmt = $dbh->prepare($sql);
        $stmt->execute([$name, $description, $price, $categoryId, $imagePath, $productId]);

        // Update sizes
        $dbh->prepare('DELETE FROM product_size WHERE product_id = ?')->execute([$productId]);
        foreach ($sizes as $size) {
            $sqlSize = 'INSERT INTO product_size (product_id, size, price_modifier) VALUES (?, ?, ?)';
            $stmtSize = $dbh->prepare($sqlSize);
            
            if (is_array($size) && isset($size['size'], $size['price_modifier'])) {
                $stmtSize->execute([$productId, $size['size'], $size['price_modifier']]);
            } else {
                error_log("Unexpected size format: " . print_r($size, true));
            }
        }

        // Update sugar levels
        $dbh->prepare('DELETE FROM product_sugar_level WHERE product_id = ?')->execute([$productId]);
        foreach ($sugarLevels as $sugarLevel) {
            $sqlSugar = 'INSERT INTO product_sugar_level (product_id, sugar_level) VALUES (?, ?)';
            $stmtSugar = $dbh->prepare($sqlSugar);
            $stmtSugar->execute([$productId, $sugarLevel]);
        }

        return true;
    }

    public function deleteProduct($productId) {
        $dbh = $this->connect();
        $sql = 'DELETE FROM product WHERE product_id = ?';
        $stmt = $dbh->prepare($sql);
        return $stmt->execute([$productId]);
    }





    //MGA EWAN
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

    public function getProductsByCategory($category_id) {
        $sql = "SELECT * FROM product WHERE category_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$category_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($productId) {
        $dbh = $this->connect();
        
        // Fetch main product details
        $stmt = $dbh->prepare("SELECT * FROM product WHERE product_id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            return null; // Product not found
        }

        // Fetch sizes associated with the product
        $stmtSize = $dbh->prepare("SELECT size, price_modifier FROM product_size WHERE product_id = ?");
        $stmtSize->execute([$productId]);
        $product['sizes'] = $stmtSize->fetchAll(PDO::FETCH_ASSOC);

        // Fetch sugar levels associated with the product
        $stmtSugar = $dbh->prepare("SELECT sugar_level FROM product_sugar_level WHERE product_id = ?");
        $stmtSugar->execute([$productId]);
        $product['sugar_levels'] = $stmtSugar->fetchAll(PDO::FETCH_ASSOC);

        return $product;
    }

    public function getAllProducts() {
        $dbh = $this->connect();
        $sql = 'SELECT * FROM product ORDER BY product_name ASC';
        $stmt = $dbh->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Other
    public function isValidCategory($category_id) {
        $sql = "SELECT COUNT(*) FROM category WHERE category_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$category_id]);
        return $stmt->fetchColumn() > 0;
    }


}