<?php

interface IModel{

    public function save($table, $data);
    public function getAll($table);
    public function get($table, $id);
    public function delete($table, $id);
    public function update($table, $data ,$id);
}