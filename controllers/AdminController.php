<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/TaskModel.php';
require_once __DIR__ . '/../controllers/AuthController.php';

class AdminController {
    private $userModel;
    private $categoryModel;
    private $taskModel;
    private $auth;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->categoryModel = new CategoryModel();
        $this->taskModel = new TaskModel();
        $this->auth = new AuthController();
    }

    public function handleRequest($action) {
        $this->auth->checkAuth(); // Verifica si el usuario está autenticado
    
        // Redirigir si no es admin
        if ($_SESSION['user_role'] !== 'admin') {
            header('Location: ' . constant('URL') . 'user');
            exit();
        }
    
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);
    
        switch ($action) {
            case 'userManagement':
                $this->userManagement();
                break;
    
            case 'categoryManagement':
                $this->categoryManagement();
                break;
    
            case 'taskManagement':
                $this->taskManagement();
                break;
    
            // case 'createUser':
            //     $this->createUser();
            //     break;
    
            // case 'storeUser':
            //     $this->storeUser();
            //     break;
    
            // case 'editUser':
            //     if (isset($url[2]) && is_numeric($url[2])) {
            //         $this->user->setId((int) $url[2]);
            //         $this->editUser();
            //     } else {
            //         error_log('AdminController::handleRequest->ID not provided in URL');
            //         echo "No user ID specified for editing.";
            //     }
            //     break;
    
            // case 'updateUser':
            //     $this->updateUser();
            //     break;
    
            // case 'deleteUser':
            //     if (isset($url[2]) && is_numeric($url[2])) {
            //         $this->user->setId((int) $url[2]);
            //         $this->deleteUser();
            //     } else {
            //         error_log('AdminController::handleRequest->ID not provided in URL');
            //         echo "No user ID specified for deletion.";
            //     }
            //     break;
    
            case 'index':
            default:
                $this->index();
                break;
        }
    }
    

    public function index() {
        $this->auth->checkAuth();
        // Verifica si el usuario tiene rol de admin
        if (!$this->isAdmin()) {
            $this->redirectWithMessage('No tienes permiso para acceder a esta página.', 'user');
        }

        $this->render('admin/index');
    }

    private function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    public function userManagement() {
        $this->auth->checkAuth();

        if (!$this->isAdmin()) {
            $this->redirectWithMessage('No tienes permiso para acceder a esta página.', 'user');
        }

        $users = $this->userModel->getAllUser();
        $this->render('admin/user_management', ['users' => $users]);
    }

    public function categoryManagement() {
        $this->auth->checkAuth();

        if (!$this->isAdmin()) {
            $this->redirectWithMessage('No tienes permiso para acceder a esta página.', 'user');
        }

        $categories = $this->categoryModel->getAllCategory(); // Método a implementar en CategoryModel
        $this->render('admin/category_management', ['categories' => $categories]);
    }

    public function taskManagement() {
        $this->auth->checkAuth();

        if (!$this->isAdmin()) {
            $this->redirectWithMessage('No tienes permiso para acceder a esta página.', 'user');
        }

        $tasks = $this->taskModel->getAllTask(); // Método a implementar en TaskModel
        $this->render('admin/task_management', ['tasks' => $tasks]);
    }

    

    private function redirectWithMessage($message, $redirectTo) {
        $_SESSION['error_message'] = $message;
        header('Location: ' . constant('URL') . $redirectTo);
        exit();
    }

    private function render($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/' . $view . '.php';
    }
}
?>
