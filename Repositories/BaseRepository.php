<?php

abstract class BaseRepository implements RepositoryInterface
{
    //model muốn tương tác
    public $model;

    //khởi tạo
    public function __construct()
    {
        $this->setModel();
    }

    //lấy model tương ứng
    abstract public function getModel();

    
    public function setModel()
    {
        $controll = new Controller();
        $this->model = $controll->model($this->getModel());
    }
    public function getAll()
    {
        return $this->model->all();
    }
    
    public function find($id)
    {
        $result = $this->model->find($id);

        return $result;
    }

    public function insert($attributes = [])
    {
        return $this->model->insertModel($attributes);
    }

    public function update($id, $attributes = [])
    {
        return $this->model->updateModel($attributes, $id);
    }

    public function delete($id)
    {
        return $this->model->deleteModel($id);
    }
}
