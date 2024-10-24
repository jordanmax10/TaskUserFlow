<?php
require_once __DIR__ . '/../models/authModel.php';

class AuthController
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
        // No llamar a session_start aquí, ya se hace en index.php

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userData = $this->login->login($username);
            if ($userData && password_verify($password, $userData->getPassword())) {
                $_SESSION['user_id'] = $userData->getId(); // Usa el método para obtener ID
                $_SESSION['user_role'] = $userData->getRole(); // Usa el método para obtener rol
                $_SESSION['username'] = $userData->getUsername();
                header('Location:' . constant('URL') . 'user');
                exit();
            } else {
                // Manejo de errores
                echo "Credenciales incorrectas.";
            }
        }
        $this->render('auth/login');
    }

    public function register(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $name = $_POST['name'];
            $role = $_POST['role'];
            $photo = $_POST['photo'];

            $this->user->setUsername($username);
            $this->user->setPassword($password);
            $this->user->setName($name);
            $this->user->setRole($role);
            $this->user->setPhoto($photo);

            if ($this->user->saveUser()) {
                header('Location: ' . constant('URL') . 'login');
                exit();
            } else {
                echo 'Error al registrar el usuario';
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

    private function render($view)
    {
        require_once __DIR__ . '/../views/' . $view . '.php';
    }
}
