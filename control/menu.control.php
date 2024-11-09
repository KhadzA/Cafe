<?php

require_once __DIR__ . '../../model/menu.model.php';

class MenuCtrl extends MenuModel {

    public function handleRequest() {
        $action = $_POST['action'] ?? '';
        $categoryId = $_POST['category_id'] ?? null;

        switch ($action) {

            // CATEGORIES
            case 'create_category':
                $this->handleCreateCategory();
                break;

            case 'update_category':
                $this->handleUpdateCategory();
                break;

            case 'delete_category':
                $this->handleDeleteCategory();
                break;

            case 'fetch_category':
                $this->handleFetchCategory();
                break;

            case 'filter_category':
                $this->handleFilterCategory();
                break;


            // PRODUCTS
            case 'create_product':
                $this->handleCreateProduct();
                break;
                
            case 'update_product':
                $this->handleUpdateProduct();
                break;
                
            case 'delete_product':
                $this->handleDeleteProduct();
                break;

            case 'fetch_product':
                $this->handleFetchProduct();
                break;

            default:
                $this->redirectTo404();
                break;
        }
    }


    //Category
    private function handleCreateCategory() {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $has_size = isset($_POST['has_size']) ? 1 : 0;
        $has_sugar_level = isset($_POST['has_sugar_level']) ? 1 : 0;

        if ($this->createCategory($name, $description, $has_size, $has_sugar_level)) {
            $this->redirectToMenu();
        } else {
            $this->redirectToMenu();
        }
    }

    private function handleUpdateCategory() {
        $id = $_POST['category_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $has_size = isset($_POST['has_size']) ? 1 : 0;
        $has_sugar_level = isset($_POST['has_sugar_level']) ? 1 : 0;

        if ($this->updateCategory($id, $name, $description, $has_size, $has_sugar_level)) {
            $this->redirectToMenuConfig();
        } else {
            $this->redirectToMenuConfig();
        }
    }

    private function handleDeleteCategory() {
        $id = $_POST['category_id'];
        $this->deleteCategory($id);
        $this->redirectToMenuConfig();
        echo json_encode(['success' => true, 'message' => 'Category deleted']);
        exit;
    }

    private function handleFetchCategory() {
        $categoryId = $_POST['category_id'] ?? null;
        if ($categoryId) {
            $category = $this->getCategoryById($categoryId);
            echo json_encode($category); 
        } else {
            echo json_encode(['error' => 'Category ID not provided']);
        }
        exit();
    }

    private function handleFilterCategory() {
        $categoryId = $_POST['category_id'] ?? null;
        $products = $categoryId ? $this->getProductsByCategory($categoryId) : $this->getAllProducts();
        echo json_encode($products);
        exit();
    }



    //Product
    private function handleCreateProduct() {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $categoryId = $_POST['category_id'];

        // Adjust the names for sizes and sugar levels arrays
        $sizes = $_POST['sizes'] ?? [];
        $sugarLevels = $_POST['sugar_levels'] ?? [];

        // Validate category ID
        if (!$this->isValidCategory($categoryId)) {
            echo "Invalid category ID.";
            exit();
    }

    // Handle image upload
    $imagePath = $this->uploadImage();

    // Call to createProduct in model with sizes and sugar levels
    if ($this->createProduct($name, $description, $price, $categoryId, $sizes, $sugarLevels, $imagePath)) {
            $this->redirectToMenu();
        } else {
            $this->redirectToMenu();
        }
    }

    private function handleUpdateProduct() {
        $productId = $_POST['product_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $categoryId = $_POST['category_id'];
        $sizes = $_POST['sizes'] ?? [];
        $sugarLevels = $_POST['sugar_levels'] ?? [];

        // Handle image upload if a new image is provided
        $imagePath = $this->uploadImage() ?: $_POST['current_image']; 

        // Call the model's updateProduct method
        if ($this->updateProduct($productId, $name, $description, $price, $categoryId, $sizes, $sugarLevels, $imagePath)) {
            $this->redirectToMenuConfig();
        } else {
            echo "Failed to update product.";
        }
    }

    private function handleDeleteProduct() {
        $productId = $_POST['product_id'];
        $this->deleteProduct($productId);
        $this->redirectToMenuConfig();
        echo json_encode(['success' => true, 'message' => 'Product deleted']);
        exit;
        }

        private function handleFetchProduct() {
        $productId = $_POST['product_id'] ?? null;

        if ($productId) {
            $product = $this->getProductById($productId);
            echo json_encode($product); 
        } else {
            echo json_encode(['error' => 'Product ID not provided']);
        }
        exit();
    }


    //Other
    private function uploadImage() {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Define the path to the 'uploads' directory relative to this file
            $targetDirectory = __DIR__ . '/../uploads/';
            
            // Ensure the target directory exists
            if (!is_dir($targetDirectory)) {
                mkdir($targetDirectory, 0777, true); // Create directory if it doesn't exist
            }

            // Define the complete path to save the image
            $imagePath = $targetDirectory . basename($_FILES['image']['name']);

            // Move the uploaded file
            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                // Return the path to save in the database
                return 'uploads/' . basename($_FILES['image']['name']);
            }
        }
        return '';
    }


    //Redirect
    private function redirectToMenu() {
        header("Location: /Menu");
        exit();
    }

    private function redirectToMenuConfig() {
        header("Location: /MenuConfig");
        exit();
    }

    private function redirectTo404() {
        header("Location: ../../pages/404.php");
        exit();
    }

}
