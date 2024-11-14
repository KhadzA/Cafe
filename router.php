<?php

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

$routes = [

    '' => 'auth/login.auth.php',

    // Authentication 
    'login' => 'auth/login.auth.php',
    'signup' => 'auth/signup.auth.php',
    'logout' => 'auth/logout.auth.php',

    // Cashier
    'cashier' => 'pages/cashier/menu.cashier.php',
    'settings' => 'pages/settings.php',

    // Admin
    'AdminDashboard' => 'pages/admin/dashboard.admin.php',
    'Menu' => 'pages/admin/menu.admin.php',
    'MenuConfig' => 'pages/admin/menuConfig.admin.php',
    'CreateOrders' => 'pages/admin/createOrders.admin.php',
    'Orders' => 'pages/admin/orders.admin.php',
    'OrderReceipt' => 'pages/admin/createReceipt.admin.php',
    'Manage' => 'pages/admin/manageUser.admin.php',
    'History' => 'pages/admin/history.admin.php',

    
    // 'control/login.control.php',
    // 'control/signup.control.php',
    // 'control/menu.control.php',

    // 'model/login.model.php',
    // 'model/signup.model.php',
    // 'model/menu.model.php',

    // 'view/login.view.php',
    // 'view/signup.view.php',
    // 'view/menu.view.php',


];


function routeToController($uri, $routes) {
    if (array_key_exists($uri, $routes)) {
        $filePath = $routes[$uri];
        
        if (file_exists($filePath)) {
            require $filePath;
        } else {
            abort();
        }
    } else {
        abort();
    }
}


function isUserRole($role) {
    return isset($_SESSION["role"]) && $_SESSION["role"] === $role;
}

function abort($code = 404) {
    http_response_code($code);
    require "pages/{$code}.php";
    die();
}

routeToController($uri, $routes);
