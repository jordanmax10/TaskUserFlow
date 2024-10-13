<?php

error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', FALSE);
ini_set('log_errors', TRUE);
ini_set('error_log', 'C:\xampp\htdocs\TaskUserFlow\php-error.log');

// error_log("PRUEBA");

//-------------------- REQUIRE --------------------

require_once './controllers/homeController.php';
require_once './controllers/userController.php';

//-------------------- ROUTING --------------------

$url = isset($_GET['url']) ? $_GET['url']: null;
$url =rtrim($url,'/'); 
$url=explode('/',$url);

switch ($url[0]) {
    case '':
        (new HomeController())->index();
        break;
    case 'user':
        $controller = new UserController();
        if (isset($url[1])) {
            $controller->handleRequest($url[1]); // Llama a la función correcta según el segmento de la URL
        } else {
            $controller->handleRequest('index'); // Acción por defecto
        }
        break;
    default:
        http_response_code(404);
        echo 'Página no encontrada';
        break;
}

