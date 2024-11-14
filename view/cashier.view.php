<?php

include __DIR__ . '../../control/cashier.control.php';

$controller = new CashierCtrl();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleRequest();
    exit();
}

$categories = $controller->getCategories();
$products = $controller->getAllProducts();
