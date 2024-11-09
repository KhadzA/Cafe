<?php

include __DIR__ . '../../control/createOrders.control.php';

$controller = new CreateOrdersCtrl();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleRequest();
    exit();
}

$categories = $controller->getCategories();
$products = $controller->getAllProducts();
