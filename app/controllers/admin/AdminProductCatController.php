<?php
class AdminProductCatController extends Controller
{
    public $model;
    public $data = array();
    public function __construct()
    {
        if (!$this->auth()) {
            $response = new Response();
            $response->redirect('admin/authcontroller/');
        }
        $this->model = $this->model('ProductCatModel');
    }
    // public function index()
    // {
    //     $this->data['cats'] = $_SESSION['user_login']['name'];
    //     $this->render('admins/product/list', $this->data);
    // }
    // public function add()
    // {
    //     $this->data['user'] = $_SESSION['user_login']['name'];
    //     $this->render('admins/product/add', $this->data);
    // }
}
