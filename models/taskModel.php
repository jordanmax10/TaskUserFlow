<?php

require_once __DIR__ . '/../libs/model.php';

class TaskModel extends Model
{
    private $id;
    private $description;
    private $status;
    private $comment;
    private $id_user;
    private $id_category;
    private $category_name;
    private $category_color;
    private $user_name;

    private $table = 'tasks';

    public function __construct()
    {
        parent::__construct();
        $this->id = '';
        $this->description = '';
        $this->status = '';
        $this->comment = '';
        $this->id_user = '';
        $this->id_category = '';
        $this->category_name = '';
        $this->category_color = '';
        $this->user_name = '';
    }

    // ------------------- CRUD -------------------

    public function saveTask(): bool
    {
        $data = [
            'description' => $this->description,
            'status' => $this->status,
            'comment' => $this->comment,
            'id_user' => $this->id_user,
            'id_category' => $this->id_category
        ];

        return parent::save($this->table, $data);
    }

    public function getAllTasks(): array
    {
        $results = parent::getAll($this->table);
        return array_map(fn($item) => (new self())->from($item), $results);
    }

    public function getTask(): ?self
    {
        $taskData = parent::get($this->table, $this->id);
        return $taskData ? $this->from($taskData) : null;
    }

    public function deleteTask(): bool
    {
        return parent::delete($this->table, $this->id);
    }

    public function updateTask(): bool
    {
        $data = [
            'description' => $this->description,
            'status' => $this->status,
            'comment' => $this->comment,
            'id_user' => $this->id_user,
            'id_category' => $this->id_category
        ];
        return parent::update($this->table, $data, $this->id);
    }

    // ------------------- ADDITIONAL FUNCTIONS -------------------

    public function from(array $data): self
    {
        $this->id = $data['id'] ?? null;
        $this->description = $data['description'] ?? '';
        $this->status = $data['status'] ?? '';
        $this->comment = $data['comment'] ?? '';
        $this->id_user = $data['id_user'] ?? null;
        $this->id_category = $data['id_category'] ?? null;
        $this->category_name = $data['category_name'] ?? '';
        $this->category_color = $data['category_color'] ?? '';
        $this->user_name = $data['user_name'] ?? '';

        return $this;
    }

    public function getTasksByUserId(int $userId): array
    {
        $items = [];
        try {
            $query = $this->prepare('
                SELECT t.*, c.name AS category_name 
                FROM ' . $this->table . ' t 
                JOIN categories c ON t.id_category = c.id 
                WHERE t.id_user = :id_user
            ');
            $query->bindParam(':id_user', $userId, PDO::PARAM_INT);
            $query->execute();

            while ($p = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new self();
                $item->from($p);
                $items[] = $item;
            }

            return $items;
        } catch (PDOException $e) {
            error_log('TaskModel::getTasksByUserId->PDOException ' . $e);
            return [];
        }
    }

    public function getAllTasksWithDetails(): array
    {
        $items = [];
        try {
            $query = $this->prepare('
    SELECT t.*, c.name AS category_name, c.color AS category_color, u.name AS user_name
    FROM ' . $this->table . ' t 
    JOIN categories c ON t.id_category = c.id 
    JOIN users u ON t.id_user = u.id
');

            $query->execute();

            while ($p = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new self();
                $item->from($p);
                $items[] = $item;
            }

            return $items;
        } catch (PDOException $e) {
            error_log('TaskModel::getAllTasksWithDetails->PDOException ' . $e);
            return [];
        }
    }


    // ------------------- GETTERS AND SETTERS -------------------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getIdUser(): int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): void
    {
        $this->id_user = $id_user;
    }

    public function getIdCategory(): int
    {
        return $this->id_category;
    }

    public function setIdCategory(int $id_category): void
    {
        $this->id_category = $id_category;
    }

    public function getCategoryName(): string
    {
        return $this->category_name; // Devuelve el nombre de la categoría
    }

    public function getCategoryColor(): string
    {
        return $this->category_color; // Devuelve el color de la categoría
    }


    public function getUserName(): string
    {
        return $this->user_name; // Devuelve el nombre del usuario
    }
}
