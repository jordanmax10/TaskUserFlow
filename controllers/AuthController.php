<?php
require_once __DIR__ . '/../models/authModel.php';
require_once __DIR__ . '/../libs/controller.php';

class AuthController extends Controller
{
    private $user;
    private $login;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->login = new AuthModel();
    }

    public function checkAuth()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . constant('URL') . 'login');
            exit();
        }
    }
    public function getUser()
    {
        $userId = $_SESSION['user_id'] ?? null;
        return $userId ? $this->user->getUser($userId) : null; // Obtener el objeto de usuario
    }



    public function login()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userData = $this->login->login($username);
            if ($userData && password_verify($password, $userData->getPassword())) {
                $_SESSION['user_id'] = $userData->getId(); // Usa el método para obtener ID
                $_SESSION['user_role'] = $userData->getRole(); // Usa el método para obtener rol
                $_SESSION['username'] = $userData->getUsername();
                $this->redirectWithMessage('¡Inicio de sesión exitoso!', 'user', 'success');
            } else {
                $this->redirectWithMessage("Credenciales incorrectas.", 'login', 'error');
            }
        }
        $this->render('auth/login');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $name = $_POST['name'];
            $role = 'user';
            $photo = $_POST['photo'];

            $this->user->setUsername($username);
            $this->user->setPassword($password);
            $this->user->setName($name);
            $this->user->setRole($role);
            $this->user->setPhoto($photo);

            if ($this->user->saveUser()) {
                $this->redirectWithMessage("Registro exitoso. Ahora puedes iniciar sesión.", 'login', 'success');
            } else {
                $this->redirectWithMessage("Error al registrar el usuario.", 'register', 'error');
            }
        }
        $this->render('auth/register');
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . constant('URL') . 'login');
        exit();
    }
}
