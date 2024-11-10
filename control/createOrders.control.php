<?php

require_once __DIR__ . '../../model/createOrders.model.php';

class CreateOrdersCtrl extends CreateOrdersModel {

    public function handleRequest() {
        $action = $_POST['action'] ?? '';
        $categoryId = $_POST['category_id'] ?? null;

        switch ($action) {

            //CATEGORY
            case 'fetch_category':
                $this->handleFetchCategory();
                break;

            case 'filter_category':
                $this->handleFilterCategory();
                break;


            //PRODUCT
            case 'fetch_product':
                $this->handleFilterCategory();
                break;


            case 'add_to_cart':
                $this->handleAddToCart();
                break;

            case 'place_orders':
                $this->handlePlaceOrder();
                break;


            default:
                $this->redirectTo404();
                break;
        }
    }


    //CATEGORY
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


    //PRODUCT
    private function handleFetchProduct() {

    }


    
    //CART
    private function handleAddToCart() {

    }


    private function handlePlaceOrder() {
        $cartItems = $_POST['cart_items'] ?? [];
        $totalAmount = $_POST['total_amount'] ?? 0;
        $userId = 1; // Placeholder user ID

        if (empty($cartItems) || $totalAmount <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid cart data']);
            exit();
        }

        // Insert into orders table
        $orderId = $this->addOrder($userId, $totalAmount);

        if (!$orderId) {
            echo json_encode(['success' => false, 'message' => 'Failed to create order']);
            exit();
        }

        // Loop through each cart item and insert into order_items
        foreach ($cartItems as $item) {
            $productId = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            
            // Check for size and sugar level IDs, set to null if not found
            $sizeId = isset($item['size']) ? $this->getSizeIdBySize($item['size']) : null;
            $sugarLevelId = isset($item['sugar_level']) ? $this->getSugarLevelIdByLevel($item['sugar_level']) : null;

            // Set `null` if `getSizeIdBySize` or `getSugarLevelIdByLevel` returned no ID
            if (!$sizeId) {
                $sizeId = null;
            }
            if (!$sugarLevelId) {
                $sugarLevelId = null;
            }

            // Insert into order_items table
            $this->addOrderItem($orderId, $productId, $userId, $quantity, $sizeId, $sugarLevelId, $price);
        }

        echo json_encode(['success' => true, 'message' => 'Order placed successfully']);
        exit();
    }


    ///REDIRECT
    private function redirectTo404() {
        header("Location: ../../pages/404.php");
        exit();
    }

    private function redirectToOrders() {
        header("Location: ../../pages/Orders");
        exit();
    }
}
