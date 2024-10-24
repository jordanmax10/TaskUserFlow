<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/TaskModel.php';

class AdminController {
    private $user;
    private $category;
    private $task;
    private $auth;

    public function __construct() {
        $this->user = new UserModel();
        $this->category = new CategoryModel();
        $this->task = new TaskModel();
        $this->auth = new AuthController();
    }

    public function index() {
        $this->auth->checkAuth();
        if ($_SESSION['user_role'] !== 'admin') {
            header('Location:'.constant('URL').'user'); // Redirige si no es admin
            echo 'No tienes permiso para acceder a esta página.';
            exit();
        }
        $this->render('admin/index');
    }

    public function userManagement() {
        $users = $this->user->getAllUser();
        $this->render('admin/user_management', ['users' => $users]);
    }

    public function categoryManagement() {
        // Logic for managing categories
    }

    public function taskManagement() {
        // Logic for managing tasks
    }

    private function render($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/' . $view . '.php';
    }
}
?>
