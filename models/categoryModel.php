<?php

require_once __DIR__ . '/../libs/model.php';


class CategoryModel extends Model 
{
    private $id;
    private $name;
    private $color;

    private $table = 'categories';


    public function __construct()
    {
        parent::__construct();
        $this->id = '';
        $this->name = '';
        $this->color = '';
    }

    // ------------------- CRUD -------------------

    public function saveCategory()
    {
        $data = [
            'name' => $this->name,
            'color' => $this->color
        ];
        return parent::save($this->table, $data);
    }

    public function getAllCategory()
    {
        $results = parent::getAll($this->table);
        return array_map(fn($item) => (new self())->from($item), $results);
    }
    public function getCategory()
    {
        $categoryData = parent::get($this->table, $this->id);
        return $categoryData ? $this->from($categoryData) : [];
    }
    public function deleteCategory()
    {
        return parent::delete($this->table, $this->id);
    }
    public function updateCategory()
    {
        $data = [
            'name' => $this->name,
            'color' => $this->color
        ];
        return parent::update($this->table, $data ,$this->id);
    }

    // ------------------- ADDITIONAL FUNCTIONS -------------------

    //Sirve para llenar los atributos de la clase con los datos que vienen de la base de datos
    public function from($array)
    {
        $this->id = $array['id'];
        $this->name = $array['name'];
        $this->color = $array['color'];

        return $this;
    }

    public function exists(string $name)
    {
        try {
            $query = $this->prepare(
                'SELECT name FROM categories WHERE name = :name'
            );
            $query->bindParam(':name', $name);
            $query->execute();

            return $query->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('CATEGORYMODEL::exists->PDOException' . $e->getMessage());
            return false;
        }
    }


    // ------------------- GETTERS & SETTERS -------------------

    public function getId(): int
    {
        return $this->id ?? 0;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }
}
