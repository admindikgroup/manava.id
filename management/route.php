<?php
$routes = [
    'xyz456' => 'calendar.php',
    'mng_ai' => 'mng_ai.php',
    'home' => 'user.php',
];

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $path);
$routeKey = end($segments);

if (isset($routes[$routeKey])) {
    include $routes[$routeKey];
} else {
    include '404.php';
}
