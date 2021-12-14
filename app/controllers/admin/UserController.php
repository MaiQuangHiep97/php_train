<?php
class UserController extends Controller
{
    public $model;
    public $data = array();
    public function __construct()
    {
        if (!isset($_SESSION['is_login'])&&!isset($_SESSION['user_login'])) {
            $response = new Response();
            $response->redirect('admin/authcontroller/');
        }
        $this->model = $this->model('UserModel');
    }
    // public function detail($id)
    // {
    //     $this->data['id'] = $id;
    //     $product = $this->model('UserModel');
    //     $this->data['ab'] = $product->getUser($id);
    //     $this->render('layouts/client', $this->data);
    // }
    public function index()
    {
        $users = $this->model('UserModel');
        $this->data['user'] = $_SESSION['user_login']['name'];
        $this->data['users'] = $users->getAll();
        $this->render('admins/user/list', $this->data);
    }
    public function edit()
    {
        echo $_GET['id'];
    }
}
