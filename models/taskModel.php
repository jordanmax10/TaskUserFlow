<?php

require_once __DIR__ . '/../libs/model.php';
require_once './models/interface/IModel.php';

class TaskModel extends Model implements IModel 
{   

    private $id;
    private $descripcion;
    private $status;
    private $comment;
    private $id_user;
    private $id_category;
    



    public function save(){

    }
    public function getAll(){

    }
    public function get(){

    }
    public function delete(){

    }
    public function update(){

    }
}
