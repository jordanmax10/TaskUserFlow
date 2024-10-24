<?php

require_once __DIR__ . '/../models/userModel.php';
require_once __DIR__ . '/../models/taskModel.php';

class UserController
{

    private $user;
    private $auth;
    private $task;

    public function __construct()
    {
        $this->auth = new AuthController();
        $this->auth->checkAuth(); // Verifica si el usuario está autenticado
        $this->user = new UserModel();
        $this->task = new TaskModel();
    }


    public function handleRequest($action) //Handle significa manejar, request significa solicitud
    {

        $this->auth->checkAuth(); // Verifica si el usuario está autenticado
        
        $url = isset($_GET['url']) ? $_GET['url'] : null;

        $url = rtrim($url, '/');
        $url = explode('/', $url);

        // Log the URL array for debugging
        // error_log('Parsed URL: ' . print_r($url, true));

        switch ($action) {

                //------------------------------------ 
            case 'create':
                $this->create();
                break;
            case 'store':
                $this->store();
                break;

                //------------------------------------ 
            case 'edit':
                if (isset($url[2]) && is_numeric($url[2])) {
                    $this->user->setId((int) $url[2]);
                    $this->edit();
                } else {
                    error_log('USERMODEL::handleRequest->ID not provided in URL');
                    echo "No user ID specified for editing.";
                }
                break;

            case 'update':
                $this->update();
                break;
                //------------------------------------ 
            case 'delete':
                if (isset($url[2]) && is_numeric($url[2])) {
                    $this->user->setId((int) $url[2]);
                    $this->delete();
                } else {
                    error_log('USERMODEL::handleRequest->ID not provided in URL');
                    echo "No user ID specified for deletion.";
                }
                break;
                //------------------------------------ 
            case 'show':
                if (isset($url[2]) && is_numeric($url[2])) {
                    $this->user->setId((int) $url[2]);
                    $this->show();
                } else {
                    error_log('USERMODEL::handleRequest->ID not provided in URL');
                    echo "No user ID specified for editing.";
                }
                break;
                break;
                //------------------------------------ 
            case 'index':
            default:
                $this->index();
                break;
        }
    }



    public function index()
    {
        $userId= $_SESSION['user_id'];
        $tasks = $this->task->getTasksByUserId($userId); // Obtiene las tareas por ID de usuario

        // Renderizar la vista y pasar la lista de usuarios
        $this->render('user/index', ['tasks' => $tasks]);

    }

    public function create()
    {
        $this->render('user/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($this->user->exists($_POST['username'])) {
                http_response_code(409);
                echo 'El usuario ya existe';
                return false;
            }
            $this->user->setUsername($_POST['username']);
            $this->user->setPassword($_POST['password']);
            $this->user->setName($_POST['name']);
            $this->user->setRole($_POST['role']);
            $this->user->setPhoto($_POST['photo']);

            if ($this->user->saveUser()) {
                http_response_code(201); // Created
                header('Location: /TaskUserFlow/user');
                exit();
            } else {
                http_response_code(500); // Internal Server Error
                echo "
                <script>
                    alert('Error al guardar el usuario');
                </script>";
                error_log('Error al guardar el usuario');
            }
        }else{
            http_response_code(405); // Method Not Allowed
            echo 'Método no permitido';
        }
    }

    public function show()
    {
        // $user = $this->user->getId();

        $user = $this->user->getUser(); // Obtiene el usuario por ID
        if ($user) {
            $this->render('user/show', ['user' => $user]);
        } else {
            http_response_code(404); // Not Found
            echo "Usuario no encontrado.";
        }
    }

    public function edit()
    {
        // $userId = $this->user->getId();

        $user = $this->user->getUser();

        if ($user) {
            $this->render('user/edit', ['user' => $user]);
        } else {
            http_response_code(404); // Not Found
            // error_log('Usuario no encontrado para ID: ' . $userId);
            echo "Usuario NO Encontrado";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->setUsername($_POST['username']);
            $this->user->setPassword($_POST['password']);
            $this->user->setName($_POST['name']);
            $this->user->setRole($_POST['role']);
            $this->user->setPhoto($_POST['photo']);
            $this->user->setId($_POST['id']);

            if ($this->user->updateUser()) {
                http_response_code(200); // OK
                header('Location: /TaskUserFlow/user');
                exit();
            } else {
                http_response_code(500); // Internal Server Error
                echo "
                <script>
                    alert('Error al actualizar el usuario');
                </script>";
                error_log('Error al actualizar el usuario');
            }
        }else{
            http_response_code(405); // Method Not Allowed
            echo 'Método no permitido';
        }
    }

    public function delete()
    {
        $userId = $this->user->getId();

        // error_log('USERMODEL::delete->ID: ' . $userId);

        if ($userId === null || $userId === 0) {
            http_response_code(400); // Bad Request
            error_log('USERMODEL::delete->ID is not set or is invalid');
            return;
        } else {
            if ($this->user->deleteUser()) {
                http_response_code(200); // OK
                header('Location: /TaskUserFlow/user');
                exit();
            } else {
                http_response_code(500); // Internal Server Error
                echo "
            <script>
                alert('Error al eliminar el usuario');
            </script>";
                error_log('Error al eliminar el usuario');
            }
        }
    }


    private function render(string $view, array $data = [])
    {
        $filePath = __DIR__ . '/../views/' . $view . '.php';

        if (file_exists($filePath)) {
            // Extraer los datos para que sean accesibles como variables en la vista
            extract($data);
            require_once $filePath;
        } else {
            http_response_code(404); //Not Found
            throw new Exception("La vista $view no se pudo encontrar.");
        }
    }
}
