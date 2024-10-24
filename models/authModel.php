<?php

require_once __DIR__ . '/../libs/model.php';
require_once __DIR__ . '/../models/userModel.php';

class AuthModel extends Model
{
    private $table = 'users';
    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = new UserModel();
    }


    public function login($username)
    {
        try {
            // Preparar la consulta
            $query = $this->prepare(
                "SELECT * FROM {$this->table} WHERE username = :username"
            );
            $query->bindParam(':username', $username);
            $query->execute();

            $userData = $query->fetch(PDO::FETCH_ASSOC);

            return $userData ? $this->user->from($userData) : null;
        } catch (PDOException $e) {
            // Registrar el error con detalles adicionales
            error_log('LoginModel::login -> Error de PDO: ' . $e->getMessage());
        }

        // En todos los casos de error, retornar null
        return null;
    }



}
