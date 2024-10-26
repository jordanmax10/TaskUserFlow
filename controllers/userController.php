<?php

require_once __DIR__ . '/../models/userModel.php';
require_once __DIR__ . '/../models/taskModel.php';
require_once __DIR__ . '/../libs/controller.php';

class UserController extends Controller
{
    private $auth;
    private $user;
    private $category;
    private $task;

    public function __construct()
    {
        $this->auth = new AuthController();
        $this->user = new UserModel();
        $this->category = new CategoryModel();
        $this->task = new TaskModel();
    }

    public function handleRequest($action)
    {
        $this->auth->checkAuth(); // Verifica si el usuario está autenticado

        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        switch ($action) {
            case 'create-task':
                $this->createTask();
                break;
            case 'store-task':
                $this->storeTask();
                break;
            case 'edit-task':
                if (isset($url[2]) && is_numeric($url[2])) {
                    $this->task->setId((int)$url[2]);
                    $this->editTask();
                } else {
                    echo "No task ID specified for editing.";
                }
                break;
            case 'update-task':
                $this->updateTask();
                break;
            case 'delete-task':
                if (isset($url[2]) && is_numeric($url[2])) {
                    $this->task->setId((int)$url[2]);
                    $this->deleteTask();
                } else {
                    echo "No task ID specified for deletion.";
                }
                break;
            case 'profile':
                $this->editProfile();
                break;
            case 'update-profile':
                $this->updateProfile();
                break;
            case 'delete-account':
                $this->deleteAccount();
                break;
            case 'index':
            default:
                $this->index();
                break;
        }
    }

    public function index()
    {
        $userId = $_SESSION['user_id'];
        $tasks = $this->task->getTasksByUserId($userId); // Obtiene las tareas por ID de usuario
        $this->render('user/index', ['tasks' => $tasks]);
    }

    public function createTask()
    {
        $user = $this->user->getAllUser();
        $categories = $this->category->getAllCategory();
        $this->render('user/create-task', ['categories' => $categories, 'user' => $user]);
    }

    public function storeTask()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->task->setDescription($_POST['description']);
            $this->task->setStatus($_POST['status']);
            $this->task->setComment($_POST['comment']);
            $this->task->setIdUser($_SESSION['user_id']); // Asignar ID de usuario
            $this->task->setIdCategory($_POST['id_category']); // ID de categoría

            if ($this->task->saveTask()) {
                $this->redirectWithMessage('Tarea creada con éxito', 'user/index', 'success');
            } else {
                $this->redirectWithMessage('Error al crear la tarea', 'user/create-task', 'error');
            }
        } else {
            http_response_code(405); // Method Not Allowed
            echo 'Método no permitido';
        }
    }

    public function editTask()
    {
        $task = $this->task->getTask();
        $categories = $this->category->getAllCategory();

        if ($task) {
            $this->render('user/edit-task', ['task' => $task, 'categories' => $categories]);
        } else {
            echo "Tarea no encontrada";
        }
    }

    public function updateTask()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->task->setDescription($_POST['description']);
            $this->task->setStatus($_POST['status']);
            $this->task->setComment($_POST['comment']);
            $this->task->setIdUser($_SESSION['user_id']);
            $this->task->setIdCategory($_POST['id_category']);
            $this->task->setId($_POST['id']);

            if ($this->task->updateTask()) {
                $this->redirectWithMessage('Tarea actualizada con éxito', 'user/index', 'success');
            } else {
                $this->redirectWithMessage('Error al actualizar la tarea', 'user/edit-task/' . $_POST['id'], 'error');
            }
        } else {
            http_response_code(405); // Method Not Allowed
            echo 'Método no permitido';
        }
    }

    public function deleteTask()
    {
        if ($this->task->deleteTask()) {
            $this->redirectWithMessage('Tarea eliminada con éxito', 'user/index', 'success');
        } else {
            $this->redirectWithMessage('Error al eliminar la tarea', 'user/index', 'error');
        }
    }

    public function editProfile()
    {
        $userId = $_SESSION['user_id'];
        $this->user->setId($userId); // Establecer el ID del usuario
        $user = $this->user->getUser(); // Obtener el usuario

        if ($user) {
            $this->render('user/profile', ['user' => $user]);
        } else {
            echo "Usuario no encontrado";
        }
    }


    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->user->setId($_SESSION['user_id']);

            $existingUser = $this->user->getUser();

            // Comienza a actualizar solo si se han cambiado los datos
            if ($existingUser) {
                // Solo actualizar si el campo no está vacío
                if (!empty($_POST['username'])) {
                    $this->user->setUsername($_POST['username']);
                } else {
                    $this->user->setUsername($existingUser->getUsername()); // Mantener el valor existente
                }

                // Actualizar contraseña solo si se proporciona un nuevo valor
                if (!empty($_POST['password'])) {
                    $this->user->setPassword($_POST['password']);
                } 

                if (!empty($_POST['name'])) {
                    $this->user->setName($_POST['name']);
                } else {
                    $this->user->setName($existingUser->getName());
                }

                $rol = '' ? 'user' : 'user';
                $this->user->setRole($rol);

                if (!empty($_POST['photo'])) {
                    $this->user->setPhoto($_POST['photo']);
                } else {
                    $this->user->setPhoto($existingUser->getPhoto());
                }

                // Actualizar el usuario
                if ($this->user->updateUser()) {
                    $this->redirectWithMessage('Usuario actualizado con éxito.', 'admin/userManagement', 'success');
                } else {
                    error_log('Error al actualizar el usuario');
                    $this->redirectWithMessage('Error al actualizar el usuario.', 'admin/userManagement', 'error');
                }
            } else {
                $this->redirectWithMessage('Usuario no encontrado.', 'admin/userManagement', 'error');
            }


            if ($this->user->updateUser()) {
                $this->redirectWithMessage('Perfil actualizado con éxito', 'user/profile', 'success');
            } else {
                $this->redirectWithMessage('Error al actualizar el perfil', 'user/profile', 'error');
            }
        } else {
            http_response_code(405); // Method Not Allowed
            echo 'Método no permitido';
        }
    }

    public function deleteAccount()
    {
        $userId = $_SESSION['user_id'];
        if ($this->user->deleteUser($userId)) {
            // Cerrar sesión y redirigir a la página de inicio
            session_destroy();
            $this->redirectWithMessage('Cuenta eliminada con éxito', '/', 'success');
        } else {
            $this->redirectWithMessage('Error al eliminar la cuenta', 'user/profile', 'error');
        }
    }
}
