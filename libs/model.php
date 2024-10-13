<?php
require_once './config/conexion.php';

class Model {

    protected $conn;

    public function __construct() {
        $this->conn = (new Conexion())->conectar();
    }

    protected function query($query) {
        return $this->conn->query($query);
    }

    protected function prepare($query) {
        return $this->conn->prepare($query);
    }

    protected function lastInsertId() {
        return $this->conn->lastInsertId();
    }
}
