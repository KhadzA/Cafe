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
        $productName = $item['product_name'];  

        // Get size and sugar level from the cart item
        $size = $item['size'];
        $sugarLevel = $item['sugar_level'];

        // Fetch size and sugar level IDs
        $sizeId = $this->getSizeIdBySize($size);
        $sugarLevelId = $this->getSugarLevelIdByLevel($sugarLevel);

        // Fetch size and sugar level names
        $sizeName = $this->getSizeNameById($sizeId);
        $sugarLevelName = $this->getSugarLevelNameById($sugarLevelId);

        // Insert into order_items table
        $this->addOrderItem($orderId, $productId, $userId, $quantity, $sizeId, $sugarLevelId, $price, $productName, $sizeName, $sugarLevelName);
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
