<?php

require_once __DIR__ . '/../libs/model.php';

class JoinTaskUserCategoryModel extends Model {
    private $taskId;
    private $description;
    private $status;
    private $comment;
    private $userId;
    private $categoryId;
    private $username;
    private $categoryName;
    private $categoryColor;

    public function __construct() {
        parent::__construct();
    }

    public function getAll($userId) {
        $items = [];
        try {
            $query = $this->prepare(
                'SELECT tasks.id as task_id, tasks.description, tasks.status, tasks.comment, 
                        tasks.id_user, tasks.id_category, 
                        users.username, categories.name as category_name, categories.color as category_color
                 FROM tasks
                 INNER JOIN users ON tasks.id_user = users.id
                 INNER JOIN categories ON tasks.id_category = categories.id
                 WHERE tasks.id_user = :user_id'
            );
            $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $query->execute();

            while ($p = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new JoinTaskUserCategoryModel();
                $item->from($p);
                array_push($items, $item);
            }

            return $items;
        } catch (\PDOException $e) {
            error_log('JoinTaskUserCategoryModel::getAll->PDOException ' . $e);
            return null;
        }
    }

    public function getCategoriesByUserId($userId) {
        $items = [];
        try {
            $query = $this->prepare(
                'SELECT categories.id as category_id, categories.name as category_name, categories.color 
                 FROM categories'
            );
            $query->execute();
    
            while ($p = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new stdClass();
                $item->id = $p['category_id'];
                $item->name = $p['category_name'];
                $item->color = $p['color'];
                array_push($items, $item);
            }
    
            return $items;
        } catch (\PDOException $e) {
            error_log('JoinTaskUserCategoryModel::getCategoriesByUserId->PDOException ' . $e);
            return null;
        }
    }
    

    public function from($array) {
        $this->taskId = $array['task_id'];
        $this->description = $array['description'];
        $this->status = $array['status'];
        $this->comment = $array['comment'];
        $this->userId = $array['id_user'];
        $this->categoryId = $array['id_category'];
        $this->username = $array['username'];
        $this->categoryName = $array['category_name'];
        $this->categoryColor = $array['category_color'];

        return $this;
    }

    public function toArray() {
        return [
            'task_id' => $this->taskId,
            'description' => $this->description,
            'status' => $this->status,
            'comment' => $this->comment,
            'user_id' => $this->userId,
            'category_id' => $this->categoryId,
            'username' => $this->username,
            'category_name' => $this->categoryName,
            'category_color' => $this->categoryColor,
        ];
    }

    // Getters and Setters
    public function getTaskId() {
        return $this->taskId;
    }

    public function setTaskId($taskId) {
        $this->taskId = $taskId;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getComment() {
        return $this->comment;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getCategoryId() {
        return $this->categoryId;
    }

    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getCategoryName() {
        return $this->categoryName;
    }

    public function setCategoryName($categoryName) {
        $this->categoryName = $categoryName;
    }

    public function getCategoryColor() {
        return $this->categoryColor;
    }

    public function setCategoryColor($categoryColor) {
        $this->categoryColor = $categoryColor;
    }
}
