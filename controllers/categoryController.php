<?php

require_once __DIR__ . '/../models/categoryModel.php';
require_once __DIR__ . '/AuthController.php';
require_once __DIR__ . '/../libs/controller.php';


class CategoryController extends Controller
{

    private $category;
    private $auth;

    public function __construct()
    {
        $this->category = new CategoryModel();
        $this->auth = new AuthController();
        $this->auth->checkAuth(); // Verifica si el usuario está autenticado

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
                $this->redirectWithMessage('Categoria guardada con éxito', 'admin/categoryManagement', 'success');
            } else {
                $this->redirectWithMessage('Error al guardar la categoria', 'admin/categoryManagement', 'error');
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
               $this->redirectWithMessage('Categoria actualizada con éxito', 'admin/categoryManagement', 'success');
            } else {
                $this->redirectWithMessage('Error al actualizar la categoria', 'admin/categoryManagement', 'error');
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
                $this->redirectWithMessage('Categoria eliminada con éxito', 'admin/categoryManagement', 'success');
            } else {
                $this->redirectWithMessage('Error al eliminar la categoria', 'admin/categoryManagement', 'error');
            }
        }
    }

    
}
