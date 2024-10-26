<?php

require_once __DIR__ . '/../libs/model.php';

class UserModel extends Model
{

    private $id;
    private $username;
    private $password;
    private $name;
    private $role;
    private $photo;

    private $table = 'users';

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

    public function saveUser()
    {
        $data = [
            'username' => $this->username,
            'password' => $this->password,
            'name' => $this->name,
            'role' => $this->role,
            'photo' => $this->photo,
        ];
        return parent::save($this->table, $data);
    }

    public function getAllUser()
    {
        // Obtiene todos los resultados (usuarios) de la base de datos
        $results = parent::getAll($this->table);

        // Usa array_map para transformar cada usuario en una nueva instancia de la clase
        return array_map(fn($item) => (new self())->from($item), $results);
    }



    public function getUser()
    {
        $userData = parent::get($this->table, $this->id);
        return $userData ? $this->from($userData) : [];
    }

    public function deleteUser()
    {
        return parent::delete($this->table, $this->id);
    }
    public function updateUser()
    {
        $data = [
            'username' => $this->username,
            'password' => $this->password,
            'name' => $this->name,
            'role' => $this->role,
            'photo' => $this->photo
        ];

        return parent::update($this->table, $data, $this->id);
    }

    // ------------------- ADDITIONAL FUNCTIONS -------------------

    public function comparePassword($password)
    {
        return password_verify($password, $this->password);
    }
    


    public function exists(string $username)
    {
        try {
            $query = $this->prepare('SELECT username FROM {$this->table} WHERE username = :username');
            $query->bindParam(':username', $username);
            $query->execute();

            return $query->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('USERMODEL::exists->PDOException' . $e->getMessage());
            return false;
        }
    }


    public function from(array $data)
    {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }
        if (isset($data['username'])) {
            $this->username = $data['username'];
        }
        if (isset($data['password'])) {
            $this->password = $data['password'];
        }
        if (isset($data['name'])) {
            $this->name = $data['name'];
        }
        if (isset($data['role'])) {
            $this->role = $data['role'];
        }
        if (isset($data['photo'])) {
            $this->photo = $data['photo'];
        }

        return $this;
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
