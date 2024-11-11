<?php

include __DIR__ . '../../control/orders.control.php';

$controller = new OrdersCtrl();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleRequest();
    exit();
}

$orders = $controller->getOrders();