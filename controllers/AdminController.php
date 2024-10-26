<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/TaskModel.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../libs/controller.php';

class AdminController extends Controller
{
    private $userModel;
    private $categoryModel;
    private $taskModel;
    private $auth;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->categoryModel = new CategoryModel();
        $this->taskModel = new TaskModel();
        $this->auth = new AuthController();
    }

    public function handleRequest($action)
    {
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
            case 'edit':
                if (isset($url[2]) && is_numeric($url[2])) {
                    $this->userModel->setId((int) $url[2]);
                    $this->edit();
                } else {
                    error_log('AdminController::handleRequest->ID not provided in URL');
                    echo "No user ID specified for editing.";
                }
                break;

            case 'update':
                $this->update();
                break;
            case 'index':
            default:
                $this->index();
                break;
        }
    }


    public function index()
    {
        $this->auth->checkAuth();
        // Verifica si el usuario tiene rol de admin
        if (!$this->isAdmin()) {
            $this->redirectWithMessage('No tienes permiso para acceder a esta página.', 'user','error');
        }

        $this->render('admin/index');
    }

    private function isAdmin()
    {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    public function userManagement()
    {
        $this->auth->checkAuth();

        if (!$this->isAdmin()) {
            $this->redirectWithMessage('No tienes permiso para acceder a esta página.', 'user','error');
        }

        $users = $this->userModel->getAllUser();
        $this->render('admin/users/user_management', ['users' => $users]);
    }
    // ************ Métodos a implementar ************

    public function edit()
    {
        $user = $this->userModel->getUser(); // Método que obtiene el usuario por ID
        if ($user) {
            $this->render('admin/users/edit', ['user' => $user]);
        } else {
            $this->redirectWithMessage('Usuario no encontrado.', 'admin/userManagement', 'error');
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $this->userModel->setId($id);
            // Obtener el usuario existente antes de la actualización
            $existingUser = $this->userModel->getUser();

            // Comienza a actualizar solo si se han cambiado los datos
            if ($existingUser) {
                // Solo actualizar si el campo no está vacío
                if (!empty($_POST['username'])) {
                    $this->userModel->setUsername($_POST['username']);
                } else {
                    $this->userModel->setUsername($existingUser->getUsername()); // Mantener el valor existente
                }

                // Actualizar contraseña solo si se proporciona un nuevo valor
                if (!empty($_POST['password'])) {
                    $this->userModel->setPassword($_POST['password']);
                } else {
                    $this->userModel->setPassword($existingUser->getPassword()); // Mantener el valor existente
                }

                if (!empty($_POST['name'])) {
                    $this->userModel->setName($_POST['name']);
                } else {
                    $this->userModel->setName($existingUser->getName());
                }

                if (!empty($_POST['role'])) {
                    $this->userModel->setRole($_POST['role']);
                } else {
                    $this->userModel->setRole($existingUser->getRole());
                }

                if (!empty($_POST['photo'])) {
                    $this->userModel->setPhoto($_POST['photo']);
                } else {
                    $this->userModel->setPhoto($existingUser->getPhoto());
                }

                // Actualizar el usuario
                if ($this->userModel->updateUser()) {
                    $this->redirectWithMessage('Usuario actualizado con éxito.', 'admin/userManagement', 'success');
                } else {
                    error_log('Error al actualizar el usuario');
                    $this->redirectWithMessage('Error al actualizar el usuario.', 'admin/userManagement', 'error');
                }
            } else {
                $this->redirectWithMessage('Usuario no encontrado.', 'admin/userManagement', 'error');
            }
        } else {
            echo "Método no permitido.";
        }
    }


    public function categoryManagement()
    {
        $this->auth->checkAuth();

        if (!$this->isAdmin()) {
            $this->redirectWithMessage('No tienes permiso para acceder a esta página.', 'user', 'error');
        }

        $categories = $this->categoryModel->getAllCategory(); // Método a implementar en CategoryModel
        $this->render('admin/category/category_management', ['categories' => $categories]);
    }

    public function taskManagement()
    {
        $this->auth->checkAuth();

        if (!$this->isAdmin()) {
            $this->redirectWithMessage('No tienes permiso para acceder a esta página.', 'user', 'error');
        }

        $tasks = $this->taskModel->getAllTask(); // Método a implementar en TaskModel
        $this->render('admin/tasks/task_management', ['tasks' => $tasks]);
    }


}
