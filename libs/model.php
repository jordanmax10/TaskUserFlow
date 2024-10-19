<?php
require_once './config/conexion.php';
require_once './models/interface/IModel.php';

class Model implements IModel
{

    protected $conn;

    public function __construct()
    {
        $this->conn = (new Conexion())->conectar();
    }

    protected function query($query)
    {
        return $this->conn->query($query);
    }

    protected function prepare($query)
    {
        return $this->conn->prepare($query);
    }

    protected function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    // ------------------- CRUD -------------------

    public function save($table, $data)
    {
        $colums = implode(", ", array_keys($data));
        $marcadores = ':' . implode(", :", array_keys($data));

        try {
            $query = $this->prepare("INSERT INTO {$table} ({$colums}) VALUES ({$marcadores})");

            foreach ($data as $key => $value) {
                $query->bindValue(":$key", $value);
            }

            return $query->execute() ? $this->lastInsertId() : false;
        } catch (PDOException $e) {
            error_log('MODEL::get->PDOException ' . $e->getMessage());
            return null;
        }
    }

    public function getAll($table)
    {
        try {
            $query = $this->prepare("SELECT * FROM {$table}");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('MODEL::get->PDOException ' . $e->getMessage());
            return null;
        }
    }

    public function get($table, $id)
    {
        try {
            $query = $this->prepare("SELECT * FROM {$table} WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();

            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('MODEL::get->PDOException ' . $e->getMessage());
            return null;
        }
    }

    public function delete($table, $id) 
    {
        try {
            $query = $this->prepare("DELETE FROM {$table} WHERE id = :id");
            $query->bindParam(':id', $id);
            return $query->execute();
        } catch (PDOException $e) {
            error_log('MODEL::delete->PDOException' . $e->getMessage());
            return false;
        }
    }
    public function update($table, $data, $id) 
    {
        try {
            $clausulaSet = '';

            foreach ($data as $key => $value) {
               $clausulaSet .= "{$key} = :{$key}, ";
            }

            //clausulaSet = name = :name, age = :age,

            $clausulaSet = rtrim($clausulaSet, ', '); //Quita la coma final
            
            $query = $this->prepare(
                "UPDATE {$table} SET {$clausulaSet} WHERE id = :id"
            );

            foreach ($data as $key => $value) {
                $query->bindValue(":$key", $value);
            }
            $query->bindParam(':id',$id);

            return $query->execute();

        } catch (PDOException $e) {
            error_log('MODEL::update->PDOException' . $e->getMessage());
            return false;
        }
    }

    
}
