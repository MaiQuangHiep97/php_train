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
        return $this->model->insert($attributes);
    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }
        return false;
    }
}
