<?php

require_once __DIR__ . '/../libs/model.php';
require_once './models/interface/IModel.php';

class UserModel extends Model implements IModel
{

    private $id;
    private $username;
    private $password;
    private $name;
    private $role;
    private $photo;

    public function __construct()
    {
        parent::__construct();
        $this->username = '';
        $this->password = '';
        $this->name = '';
        $this->role = '';
        $this->photo = '';
    }


    // ------------------- CRUD -------------------

    public function save()
    {
        try {
            $query = $this->prepare(
                "INSERT INTO users(username, password, name, role, photo)
                VALUES (:username, :password, :name, :role, :photo)"
            );

            $query->bindParam(':username', $this->username);
            $query->bindParam(':password', password_hash($this->password, PASSWORD_DEFAULT));
            $query->bindParam(':name', $this->name);
            $query->bindParam(':role', $this->role);
            $query->bindParam(':photo', $this->photo);

            $result = $query->execute();
        
        if ($result) {
            $this->id = $this->lastInsertId(); // Retrieve and set the ID after insertion
        }
        
        return $result;
        } catch (PDOException $e) {
            error_log('USERMODEL::save->PDOException' . $e->getMessage());
            return false;
        }
    }
    public function getAll()
    {
        $items = [];
        try {
            $query = $this->query("SELECT * FROM users");
            $results = $query->fetchAll(PDO::FETCH_ASSOC); 

            // Log para depuración
            // error_log(print_r($results, true)); 

            foreach ($results as $result) {
                $user = new UserModel(); 
                $items[] = $user->from($result); 
            }

            // Log para verificar el contenido de $items
            // error_log(print_r($items, true)); 

            return $items; 

        } catch (PDOException $e) {
            error_log('USERMODEL::getAll->PDOException' . $e->getMessage());
            return [];
        }
    }




    public function get()
    {
        try {
            $query = $this->prepare("SELECT * FROM users WHERE id = :id");
            $query->bindParam(':id', $this->id);
            $query->execute();

            $user = $query->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                return $this->from($user);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log('USERMODEL::get->PDOException' . $e->getMessage());
            return null;
        }
    }
    public function delete()
    {
        try {
            $query = $this->prepare("DELETE FROM users WHERE id = :id");
            $query->bindParam(':id', $this->id);
            return $query->execute();
        } catch (PDOException $e) {
            error_log('USERMODEL::delete->PDOException' . $e->getMessage());
            return false;
        }
    }
    public function update()
    {
        try {
            $query = $this->prepare(
                "UPDATE users SET username = :username, password = :password, name = :name, role = :role, photo = :photo WHERE id = :id"
            );
            $query->bindParam(':id', $this->id);
            $query->bindParam(':username', $this->username);
            $query->bindParam(':password', password_hash($this->password, PASSWORD_DEFAULT));
            $query->bindParam(':name', $this->name);
            $query->bindParam(':role', $this->role);
            $query->bindParam(':photo', $this->photo);
            return $query->execute();
        } catch (PDOException $e) {
            error_log('USERMODEL::update->PDOException' . $e->getMessage());
            return false;
        }
    }

    // ------------------- ADDITIONAL FUNCTIONS -------------------

    public function comparePassword($password)
    {
        return password_verify($password, $this->password);
    }


    //Sirve para llenar los atributos de la clase con los datos que vienen de la base de datos
    public function from($array)
    {
        $this->id = $array['id'];
        $this->username = $array['username'];
        $this->password = $array['password'];
        $this->name = $array['name'];
        $this->role = $array['role'];
        $this->photo = $array['photo'];

        return $this;
    }

    public function exists(string $username)
    {
        try {
            $query = $this->prepare('SELECT username FROM users WHERE username = :username');
            $query->bindParam(':username', $username);
            $query->execute();

            return $query->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('USERMODEL::exists->PDOException' . $e->getMessage());
            return false;
        }
    }

    // ------------------- GETTERS & SETTERS -------------------

    public function getId(): int
    {
        return $this->id ?? 0;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        if ($password) {
            $this->password = password_hash($password, PASSWORD_DEFAULT);
        }
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): void
    {
        $this->photo = $photo;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
