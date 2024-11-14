<?php

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

$routes = [

    '' => 'auth/login.auth.php',

    // Auth
    'login' => 'auth/login.auth.php',
    'signup' => 'auth/signup.auth.php',
    'logout' => 'auth/logout.auth.php',

    // Cashier
    'cashier' => 'pages/cashier/menu.cashier.php',
    'order' => 'pages/cashier/orders.cashier.php',
    'history' => 'pages/cashier/history.cashier.php',
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

<<<<<<< HEAD
routeToController($uri, $routes);







// $routes = [
//     '/' => 'auth/login.auth.php',

//     // Authentication 
//     '/login' => 'auth/login.auth.php',
//     '/signup' => 'auth/signup.auth.php',
//     '/logout' => 'auth/logout.auth.php',

//     // Cashier
//     '/cashier' => 'pages/cashier/menu.cashier.php',
//     '/order' => 'pages/cashier/orders.cashier.php',
//     '/history' => 'pages/cashier/history.cashier.php',
//     '/settings' => 'pages/settings.php',

//     // Admin
//     '/AdminDashboard' => 'pages/admin/dashboard.admin.php',
//     '/Menu' => 'pages/admin/menu.admin.php',
//     '/MenuConfig' => 'pages/admin/menuConfig.admin.php',
//     '/CreateOrders' => 'pages/admin/createOrders.admin.php',
//     '/Orders' => 'pages/admin/orders.admin.php',
//     '/OrderReceipt' => 'pages/admin/createReceipt.admin.php',
//     '/Manage' => 'pages/admin/manageUser.admin.php',
//     '/History' => 'pages/admin/history.admin.php',
// ];

// function routeToController($routes) {
//     $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//     // Check if the route exists
//     if (array_key_exists($currentPath, $routes)) {
//         $filePath = $routes[$currentPath];

//         // Check if the file exists and include it
//         if (file_exists($filePath)) {
//             require $filePath;
//         } else {
//             abort(404); // File not found
//         }
//     } else {
//         abort(404); // Route not found
//     }
// }

// function isUserRole($role) {
//     return isset($_SESSION["role"]) && $_SESSION["role"] === $role;
// }

// function abort($code = 404) {
//     http_response_code($code);
//     require "pages/{$code}.php";
//     die();
// }

// routeToController($routes);
=======
routeToController($uri, $routes);
>>>>>>> 6440243 (DONE?)
