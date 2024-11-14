<?php

include __DIR__ . '../../control/manageUser.control.php';

$controller = new ManageUserCtrl();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleRequest();
    exit();
}

$users = $controller->getUsers();
