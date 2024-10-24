<?php


error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', FALSE);
ini_set('log_errors', TRUE);
ini_set('error_log', 'C:\xampp\htdocs\TaskUserFlow\php-error.log');

//-------------------- REQUIRE --------------------
require_once './controllers/homeController.php';
require_once './controllers/userController.php';
require_once './controllers/categoryController.php';
require_once './controllers/taskController.php';
require_once './controllers/AuthController.php';
require_once './controllers/AdminController.php';

//-------------------- INICIAR SESIÓN --------------------
session_start();

//-------------------- ROUTING --------------------
$url = isset($_GET['url']) ? $_GET['url'] : '';
$url = rtrim($url, '/');
$url = explode('/', $url);

switch ($url[0]) {
    case '':
        (new HomeController())->login();
        break;
    case 'user':
        $userController = new UserController();
        $userController->handleRequest($url[1] ?? 'index');
        break;

    case 'admin':
        $adminController = new AdminController();
        $adminController->handleRequest($url[1] ?? 'index');
        break;

    case 'login':
        (new AuthController())->login();
        break;

    case 'register':
        (new AuthController())->register();
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    case 'category':
        $categoryController = new CategoryController();
        if (isset($url[1])) {
            $categoryController->handleRequest($url[1]);
        } else {
            $categoryController->handleRequest('index');
        }
        break;

    case 'task':

        $taskController = new TaskController();
        if (isset($url[1])) {
            $taskController->handleRequest($url[1]);
        } else {
            $taskController->handleRequest('index');
        }

        break;

    default:
        http_response_code(404);
        echo 'Página no encontrada';
        break;
}
