<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
    '/' => 'src/main/landingPage.php',
    '/login' => 'src/main/login.php',
    '/signup' => 'src/main/signup.php',
    '/cashier' => 'src/main/cashier.php',
    '/history' => 'src/main/history.php',
    '/dashBoard' => 'src/main/dashBoard.php',
    '/myproducts' => 'src/main/myproducts.php',
    '/reports' => 'src/main/reports.php',
    '/settings' => 'src/main/settings.php',
    '/productView' => 'src/view/productView.php',
];

function routeToController($uri, $routes) {
    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        abort();
    }
}

function abort($code = 404) {
    http_response_code($code);

    require "src/main/{$code}.php";

    die();
}

echo routeToController($uri, $routes);