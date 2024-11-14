<?php

include __DIR__ . '../../control/order.control.php';

$controller = new OrderCtrl();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleRequest();
    exit();
}

$orders = $controller->getOrders();

$ordersHistory = $controller->getHistory();

$order_id = $_GET['order_id'] ?? null;
$order = $controller->getOrderById($order_id); 
$order_items = $controller->getOrderItems($order_id);

$cash_given = $_GET['cash_given'] ?? null;
$change = $_GET['change'] ?? null;