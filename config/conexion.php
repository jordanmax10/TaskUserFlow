<?php

require_once 'config.php';

class Conexion{

    private $host = DB_HOST;
    private $dbname = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASSWORD;

    public function conectar()  {
        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
    
            $conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass, $options);
    
            return $conn;
        } catch (PDOException $e) {
            echo "Error en la Conexion".$e->getMessage();
            error_log('CONEXION::conectar->PDOException' . $e->getMessage());
        }    
    }
}