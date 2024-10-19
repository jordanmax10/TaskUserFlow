<?php

require_once __DIR__ . '/../models/categoryModel.php';

class CategoryController
{

    private $category;

    public function __construct()
    {
        $this->category = new CategoryModel();
    }

    public function handleRequest($action)
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        switch ($action) {

            case 'create':
                $this->create();
                break;
            case 'store':
                $this->store();
                break;
            case 'edit':
                if(isset($url[2]) && is_numeric($url[2])){
                    $this->category->setId((int) $url[2]);
                    $this->edit();
                }else{
                    error_log('CATEGORYMODEL::HandleRequest->ID Not Provided in URL');
                    echo "No category ID specified for editing.";
                }
                break;
            case 'update':
                $this->update();
                break;
            case 'delete':
                if(isset($url[2]) && is_numeric($url[2])){
                    $this->category->setId((int) $url[2]);
                    $this->delete();
                }else{
                    error_log('CATEGORYMODEL::HandleRequest->ID Not Provided in URL');
                    echo "No category ID specified for editing.";
                }
                break;
            case 'index':
            default:
                $this->index();
                break;
        }
    }

    public function index()
    {
        $categories = $this->category->getAllCategory();
        $this->render('category/index', ['categories' => $categories]);
    }

    public function create()
    {
        $this->render('category/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->category->exists($_POST['name'])) {
                echo "La categoria ya existe";
                return false;
            }

            $this->category->setName($_POST['name']);
            $this->category->setColor($_POST['color']);

            if ($this->category->saveCategory()) {
                header('Location: /TaskUserFlow/category');
                exit();
            } else {
                echo "
                <script>
                alert('Error al guardar la categoria');
                </script>";
                error_log('Error al guardar la categoria');
            }
        }
    }


    public function edit()
    {
        $category = $this->category->getCategory();

        if ($category) {
            $this->render('category/edit', ['category' => $category]);
        } else {
            http_response_code(404);
            echo "Categoria No Encontrada";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->category->setName($_POST['name']);
            $this->category->setColor($_POST['color']);
            $this->category->setId($_POST['id']);


            if ($this->category->updateCategory()) {
                http_response_code(200);
                header('Location: /TaskUserFlow/category');
                exit();
            } else {
                http_response_code(500); // Internal Server Error
                echo "
            <script>
                alert('Error al actualizar la categoria');
            </script>";
                error_log('Error al actualizar la categoria');
            }
        } else {
            http_response_code(405); // Method Not Allowed
            echo 'Método no permitido';
        }
    }

    public function delete()  {
        $categoryId=$this->category->getId();

        if($categoryId === null || $categoryId === 0){
            http_response_code(400);
            error_log('CATEGORYMODEL::delete->ID is not set or is invalid');
            return;
        }else{
            if($this->category->deleteCategory()){
                http_response_code(200); // OK
                header('Location: /TaskUserFlow/category');
                exit();
            } else {
                http_response_code(500); // Internal Server Error
                echo "
            <script>
                alert('Error al eliminar la categoria');
            </script>";
                error_log('Error al eliminar la categoria');
            }
        }
    }

    private function render(string $view, array $data = [])
    {

        $filePath = __DIR__ . '/../views/' . $view . '.php';

        if (file_exists($filePath)) {

            extract($data);
            require_once $filePath;
        } else {
            http_response_code(404);
            echo "Pagina No Encontrada";
        }
    }
}
