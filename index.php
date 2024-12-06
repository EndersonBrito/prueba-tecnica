<?php

define('BASE_DIR', __DIR__);  // c:/xampp/htdocs/Super
// Definir url base para estilos y enlaces
define('BASE_URL', 'http://prueba-tecnica.test/');
$request = $_SERVER['REQUEST_URI'];
$viewDir = '/view/';
$controllerDir = '/controller/';

switch ($request) {
    case '':
    case '/':
        require __DIR__ . $viewDir . 'login.php';
        break;
    case '/register':
        require __DIR__ . $viewDir . 'register.php';
        break;
    case '/home':
        require __DIR__ . $viewDir . 'home.php';
        break;
    case '/category':
        require __DIR__ . $viewDir . 'category.php';
        break;

    case '/product':
        require __DIR__ . $viewDir . 'product.php';
        break;
    case '/categoryController':
        require __DIR__ . $controllerDir . 'categoryController.php';
        break;
    case '/productController':
        require __DIR__ . $controllerDir . 'productController.php';
        break;
    case '/loginController':
        require __DIR__ . $controllerDir . 'loginController.php';
        break;
            
    case '/ventas':
        require __DIR__ . $viewDir . 'ventas.php';
        break;
        case '/ventasController':
            require __DIR__ . $controllerDir . 'ventasController.php';
            break;
    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}