<?php

require_once __DIR__.'/../../models/userModel.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $errorMessage = 'Por favor, completa todos los campos.';
        include 'login.php'; // Vuelve a cargar la vista del login con el mensaje de error
        exit;
    }

    $userModel = new UserModel();
    $user = $userModel->getByUsername($username);

    if ($user && $user->comparePassword($password)) {
        // Si la autenticación es correcta, se inicia la sesión del usuario
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['role'] = $user->getRole();

        // Redirige al usuario a la página principal o dashboard
        header('Location: dashboard.php');
        exit;
    } else {
        $errorMessage = 'Nombre de usuario o contraseña incorrectos.';
        include 'login.php'; // Vuelve a cargar la vista del login con el mensaje de error
    }
}
