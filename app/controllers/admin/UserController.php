<?php
class UserController extends Controller
{
    public $model;
    public $data = array();
    // public function index()
    // {
    //     echo $this->model->getUser($id);
    // }
    public function __construct()
    {
        $this->model = $this->model('UserModel');
    }
    public function detail($id)
    {
        $this->data['id'] = $id;
        $product = $this->model('UserModel');
        $this->data['ab'] = $product->getUser($id);
        $this->render('layouts/client', $this->data);
    }
}
