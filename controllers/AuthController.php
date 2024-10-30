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
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Intenta obtener los datos del usuario
        $userData = $this->login->login($username);

        if (!$userData) {
            // El usuario no existe
            $this->redirectWithMessage("No tienes cuenta. Por favor, regístrate.", 'register', 'error');
            return;
        }

        // El usuario existe, verifica la contraseña
        if (password_verify($password, $userData->getPassword())) {
            $_SESSION['user_id'] = $userData->getId(); // Usa el método para obtener ID
            $_SESSION['user_role'] = $userData->getRole(); // Usa el método para obtener rol
            $_SESSION['username'] = $userData->getUsername();
            $this->redirectWithMessage('¡Inicio de sesión exitoso!', 'user', 'success');
        } else {
            // La contraseña es incorrecta
            $this->redirectWithMessage("Credenciales incorrectas", 'login', 'error');
        }
    }
    $this->render('auth/login');
}


    public function register()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $name = trim($_POST['name']);
        $role = 'user';

        // Validar entrada
        if (empty($username) || empty($password) || empty($name)) {
            $this->redirectWithMessage('Por favor completa todos los campos.', 'register', 'error');
            return;
        }

        $this->user->setUsername($username);
        $this->user->setPassword($password); // Cifrar la contraseña
        $this->user->setName($name);
        $this->user->setRole($role);

        // Manejo de la foto
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $photo = $_FILES['photo'];
            $dest_path = __DIR__ . '/../public/img/fotos-u/';
            $extension = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));

            // Validar tipo de archivo
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($extension, $allowedExtensions)) {
                $this->redirectWithMessage('Tipo de archivo no permitido', 'register', 'error');
                return;
            }

            $check = getimagesize($photo['tmp_name']);
            if ($check === false) {
                $this->redirectWithMessage('El archivo no es una imagen', 'register', 'error');
                return;
            }

            $hash = md5(uniqid(rand(), true)) . '.' . $extension; // Generar un nombre único para el archivo
            $targetFile = $dest_path . $hash;

            // Mover el archivo
            if (move_uploaded_file($photo['tmp_name'], $targetFile)) {
                $this->user->setPhoto($hash);
            } else {
                $this->redirectWithMessage('Error al subir la imagen', 'register', 'error');
                return;
            }
        }

        // Guardar el usuario
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
