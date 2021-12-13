<?php
class Controller
{
    public $db;
    public function model($model)
    {
        if (file_exists(_DIR_ROOT.'/app/models/'.$model.'.php')) {
            require_once _DIR_ROOT.'/app/models/'.$model.'.php';
            if (class_exists($model)) {
                $model = new $model();
                return $model;
            }
        } else {
            echo "lỗi";
        }
    }
    public function render($view, $data=[])
    {
        extract($data);
        if (file_exists(_DIR_ROOT.'/app/views/'.$view.'.php')) {
            require_once _DIR_ROOT.'/app/views/'.$view.'.php';
        }
    }
}
