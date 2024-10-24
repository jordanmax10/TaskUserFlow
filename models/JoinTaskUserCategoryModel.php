<?php
require_once __DIR__.'/../libs/model.php';

class JoinModel extends Model {

    public function getTasksWithUser() {
        $query = "
            SELECT 
                tasks.id AS task_id,
                tasks.description,
                tasks.status,
                tasks.comment,
                tasks.id_user,
                users.username,
                users.name AS user_name
            FROM 
                tasks
            JOIN 
                users ON tasks.id_user = users.id
        ";

        return $this->executeQuery($query);
    }

    public function getTasksWithCategory() {
        $query = "
            SELECT 
                tasks.id AS task_id,
                tasks.description,
                tasks.status,
                tasks.comment,
                tasks.id_category,
                categories.name AS category_name,
                categories.color AS category_color
            FROM 
                tasks
            JOIN 
                categories ON tasks.id_category = categories.id
        ";

        return $this->executeQuery($query);
    }

    public function getTasksWithUserAndCategory() {
        $query = "
            SELECT 
                tasks.id AS task_id,
                tasks.description,
                tasks.status,
                tasks.comment,
                users.username,
                users.name AS user_name,
                categories.name AS category_name,
                categories.color AS category_color
            FROM 
                tasks
            JOIN 
                users ON tasks.id_user = users.id
            JOIN 
                categories ON tasks.id_category = categories.id
        ";

        return $this->executeQuery($query);
    }

    public function getUsersWithTasks() {
        $query = "
            SELECT 
                users.id AS user_id,
                users.username,
                users.name AS user_name,
                tasks.id AS task_id,
                tasks.description,
                tasks.status
            FROM 
                users
            LEFT JOIN 
                tasks ON users.id = tasks.id_user
        ";

        return $this->executeQuery($query);
    }

    public function getCategoriesWithTasks() {
        $query = "
            SELECT 
                categories.id AS category_id,
                categories.name AS category_name,
                categories.color AS category_color,
                tasks.id AS task_id,
                tasks.description,
                tasks.status
            FROM 
                categories
            LEFT JOIN 
                tasks ON categories.id = tasks.id_category
        ";

        return $this->executeQuery($query);
    }

    public function getCategoriesByUserId($userId) {
        $query = "
            SELECT 
                categories.id,
                categories.name
            FROM 
                categories
            JOIN 
                tasks ON categories.id = tasks.id_category
            WHERE 
                tasks.id_user = :userId
        ";
    
        $stmt = $this->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Función para ejecutar consultas y devolver resultados
    protected function executeQuery($query) {
        try {
            $stmt = $this->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('JoinModel::executeQuery -> Error de PDO: ' . $e->getMessage());
            return [];
        }
    }
}
?>
