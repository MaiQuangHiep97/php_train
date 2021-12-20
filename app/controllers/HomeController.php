<?php
class HomeController extends Controller
{
    public $model;
    public $data = array();
    public function index()
    {
        if (isset($_SESSION['customer_login'])) {
            $this->data['customer'] = $_SESSION['customer_login'];
        }
        $this->render('clients/home/index', $this->data);
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
