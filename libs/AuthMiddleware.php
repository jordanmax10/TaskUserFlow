<?php
class AuthMiddleware {
    public static function checkRole($role) {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== $role) {
            header('Location:'.constant('URL') .'login'); // Redirige a la página de inicio de sesión
            exit();
        }
    }
}
?>
