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

            case 'place_order':
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

    }



    ///REDIRECT
    private function redirectTo404() {
        header("Location: ../../pages/404.php");
        exit();
    }
}
