<?php

require_once __DIR__ . '/../libs/model.php';
require_once './models/interface/IModel.php';

class CategoryModel extends Model implements IModel
{
    private $id;
    private $name;
    private $color;


    public function __construct()
    {
        parent::__construct();
        $this->id='';
        $this->name='';
        $this->color='';
    }

    // ------------------- CRUD -------------------

    public function save() {
        try {
            $query = $this->prepare(
                "INSERT INTO categories(name, color)
                VALUES (:name, :color)"
            );

            $query->bindParam(':name',$this->name);
            $query->bindParam(':color',$this->color);

            if ($query->rowCount() > 0) return true;

            return false;
        } catch (PDOException $e) {
            error_log('CATEGORMODEL::save->PDOException ' . $e);
            return false;
        }
    }
    public function getAll() {
        $items =[];

        try {
            $query = $this->prepare("SELECT * FROM categories");
            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach($results as $result){
                $category = new CategoryModel();
                $items[] = $category->from($result);
            }

            return $items;
        } catch (PDOException $e) {
            error_log('CATEGORYMODEL::getAll->PDOException'.$e->getMessage());
            return [];
        }
    }
    public function get() {
        try {
            $query = $this->prepare(
                "SELECT * FROM categories WHERE id = :id"
            );
            $query->bindParam(':id',$this->id);

            $category = $query->fetch(PDO::FETCH_ASSOC);

            if($category){
                return $this->from($category);
            }else{
                return null;
            }
        } catch (PDOException $e) {
            error_log('CATEGORYMODEL::get->PDOException ' . $e->getMessage());
            return null;
        }
    }
    public function delete() {
        try {
            $query = $this->prepare(
                "DELETE FROM categories WHERE id = :id"
            );
            $query->bindParam(':id',$this->id);
            return $query->execute();
        } catch (PDOException $e) {
            error_log('CATEGORYMODEL::delete->PDOException' . $e->getMessage());
            return false;
        }
    }
    public function update() {
        try {
            $query = $this->prepare(
                "UPDATE categories SET name = :name, color = :color
                WHERE id = :id"
            );
            $query->bindParam(':name', $this->name);
            $query->bindParam('color',$this->color);

            return $query->execute();
        } catch (PDOException $e) {
            error_log('CATEGORYMODEL::update->PDOException ' . $e->getMessage());
            return false;
        }
    }

    // ------------------- ADDITIONAL FUNCTIONS -------------------
    
    //Sirve para llenar los atributos de la clase con los datos que vienen de la base de datos
    public function from($array)  {
        $this->id = $array['id'];
        $this->name =$array['name'];
        $this->color =$array['color'];

        return $this;
    }

    public function exists(string $name) {
        try {
            $query = $this->prepare(
                'SELECT name FROM categories WHERE name = :name'
            );
            $query->bindParam(':name',$name);
            $query->execute();

            return $query->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('CATEGORYMODEL::exists->PDOException'.$e->getMessage());
            return false;
        }
    }


    // ------------------- GETTERS & SETTERS -------------------

    public function getId() : int {
        return $this->id ?? 0;
    }

    public function setId($id) : void {
        $this->id = $id;
    }

    public function getName() : string {
        return $this->name;
    }

    public function setName(string $name) : void {
        $this->name = $name;
    }

    public function getColor() :string {
        return $this->color;
    }

    public function setColor(string $color) :void{
        $this->color = $color;
    }
}
