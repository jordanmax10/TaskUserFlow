<?php

require_once __DIR__ . '/../models/userModel.php';

class UserController
{

    private $user;
    public function __construct()
    {
        $this->user = new UserModel();
    }


    public function handleRequest($action) //Handle significa manejar, request significa solicitud
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;

        $url = rtrim($url, '/');
        $url = explode('/', $url);

        // Log the URL array for debugging
        // error_log('Parsed URL: ' . print_r($url, true));

        switch ($action) {
            case 'create':
                $this->create();
                break;
            case 'store':
                $this->store();
                break;
            case 'edit':
                if (isset($url[2]) && is_numeric($url[2])) {
                    $this->user->setId((int) $url[2]);
                    $this->edit();
                } else {
                    error_log('USERMODEL::handleRequest->ID not provided in URL');
                    echo "No user ID specified for editing.";
                }
                break;
            case 'delete':
                if (isset($url[2]) && is_numeric($url[2])) {
                    $this->user->setId((int) $url[2]);
                    $this->delete();
                } else {
                    error_log('USERMODEL::handleRequest->ID not provided in URL');
                    echo "No user ID specified for deletion.";
                }
                break;
            case 'update':
                $this->update();
                break;
            case 'show':
                $this->show();
                break;
            case 'index':
            default:
                $this->index();
                break;
        }
    }



    public function index()
    {
        $userModel = new UserModel();
        $users = $userModel->getAll();
        // error_log(print_r($users, true));

        // Renderizar la vista y pasar la lista de usuarios
        $this->render('user/index', ['users' => $users]);
    }

    public function create()
    {
        $this->render('user/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($this->user->exists($_POST['username'])) {
                echo 'El usuario ya existe';
                return;
            }
            $this->user->setUsername($_POST['username']);
            $this->user->setPassword($_POST['password']);
            $this->user->setName($_POST['name']);
            $this->user->setRole($_POST['role']);
            $this->user->setPhoto($_POST['photo']);

            if ($this->user->save()) {
                header('Location: /TaskUserFlow/user');
                exit();
            } else {
                echo "
                <script>
                    alert('Error al guardar el usuario');
                </script>";
                error_log('Error al guardar el usuario');
            }
        }
    }

    public function show()
    {
        // Manejar la lógica para mostrar el usuario
        $this->render('user/show');
    }

    public function edit()
    {
        $userId = $this->user->getId();

        $user = $this->user->get();

        if ($user) {
            $this->render('user/edit', ['user' => $user]);
        } else {
            error_log('Usuario no encontrado para ID: ' . $userId);
            echo "Usuario NO Encontrado";
        }
    }

    public function update()
    {
        echo "
        <script>
            alert('Actualizando usuario');
            </script>";
    }

    public function delete()
    {
        $userId = $this->user->getId();

        error_log('USERMODEL::delete->ID: ' . $userId);

        if ($userId === null || $userId === 0) {
            error_log('USERMODEL::delete->ID is not set or is invalid');
            return;
        } else {
            if ($this->user->delete()) {
                header('Location: /TaskUserFlow/user');
                exit();
            } else {
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
            http_response_code(404);
            echo 'Página no encontrada';
        }
    }
}
