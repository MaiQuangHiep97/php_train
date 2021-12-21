<?php
class CartController extends Controller
{
    public $model;
    public $data = array();
    public function __construct()
    {
        $this->model = $this->model('ProductModel');
    }
    public function index()
    {
    }
    public function add()
    {
    }
}
