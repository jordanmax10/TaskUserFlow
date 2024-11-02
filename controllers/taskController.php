<?php

require_once __DIR__ . '/../models/TaskModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/AuthController.php';

class TaskController
{
    private $task;
    private $auth;
    private $user;
    private $category;

    public function __construct()
    {
        $this->task = new TaskModel();
        $this->auth = new AuthController();
        $this->user = new UserModel();
        $this->category = new CategoryModel();
        $this->auth->checkAuth(); // Verifica si el usuario está autenticado
    }

    public function handleRequest($action)
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        switch ($action) {
            case 'create':
                $this->create();
                break;
            case 'store':
                $this->store();
                break;
            case 'edit':
                if (isset($url[2]) && is_numeric($url[2])) {
                    $this->task->setId((int)$url[2]);
                    $this->edit();
                } else {
                    $this->error('No task ID specified for editing.');
                }
                break;
            case 'update':
                $this->update();
                break;
            case 'delete':
                if (isset($url[2]) && is_numeric($url[2])) {
                    $this->task->setId((int)$url[2]);
                    $this->delete();
                } else {
                    $this->error('No task ID specified for deletion.');
                }
                break;
            case 'index':
            default:
                $this->index();
                break;
        }
    }

    public function index()
    {
        $tasks = $this->task->getAllTasks();
        $this->render('tasks/index', ['tasks' => $tasks, 'user' => $this->user]);
    }

    public function create()
    {
        $categories = $this->category->getAllCategory();
        $this->render('tasks/create', ['categories' => $categories, 'user' => $this->user]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->task->setDescription($_POST['description']);
            $this->task->setStatus($_POST['status']);
            $this->task->setComment($_POST['comment']);
            $this->task->setIdUser($this->user->getId());
            $this->task->setIdCategory($_POST['id_category']);

            if ($this->task->saveTask()) {
                header('Location: /TaskUserFlow/tasks');
                exit();
            } else {
                $this->error('Error al guardar la tarea');
            }
        } else {
            $this->error('Método no permitido');
        }
    }

    public function edit()
    {
        $taskData = $this->task->getTask();
        if ($taskData) {
            $this->render('tasks/edit', ['task' => $taskData, 'user' => $this->user]);
        } else {
            $this->error('Tarea no encontrada');
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->task->setDescription($_POST['description']);
            $this->task->setStatus($_POST['status']);
            $this->task->setComment($_POST['comment']);
            $this->task->setIdUser($this->user->getId());
            $this->task->setIdCategory($_POST['id_category']);
            $this->task->setId($_POST['id']);

            if ($this->task->updateTask()) {
                header('Location: /TaskUserFlow/tasks');
                exit();
            } else {
                $this->error('Error al actualizar la tarea');
            }
        } else {
            $this->error('Método no permitido');
        }
    }

    public function delete()
    {
        if ($this->task->deleteTask()) {
            header('Location: /TaskUserFlow/tasks');
            exit();
        } else {
            $this->error('Error al eliminar la tarea');
        }
    }

    private function render(string $view, array $data = [])
    {
        $filePath = __DIR__ . '/../views/' . $view . '.php';

        if (file_exists($filePath)) {
            extract($data);
            require_once $filePath;
        } else {
            $this->error('Página no encontrada');
        }
    }

    private function error($message)
    {
        // Manejar errores y mostrar un mensaje
        echo "<script>alert('$message');</script>";
        error_log($message);
        http_response_code(400); // Bad Request
    }
}
