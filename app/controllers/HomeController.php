<?php
class HomeController extends Controller
{
    public $model;
    public $data = array();
    public function index()
    {
        var_dump($this->model->getList());
    }
    public function __construct()
    {
        $this->model = $this->model('HomeModel');
    }
    public function detail()
    {
        $product = $this->model('HomeModel');
        $this->data['ab'] = $product->getList();
        $this->render('layouts/client', $this->data);
    }
}
