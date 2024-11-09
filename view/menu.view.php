<?php

include __DIR__ . '../../control/menu.control.php';

$controller = new MenuCtrl();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleRequest();
    exit();
}

$categories = $controller->getCategories();
$products = $controller->getAllProducts();
