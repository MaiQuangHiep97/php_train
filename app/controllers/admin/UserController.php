<?php
class UserController extends Controller
{
    public $model;
    public $data = array();
    public function __construct()
    {
        if (!$this->auth()) {
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
    public function add()
    {
        $this->render('admins/user/add');
    }
    public function store()
    {
        if (isset($_POST)) {
            $data = [
            'name'=>$_POST['username'],
            'email'=>$_POST['email'],
            'phone'=>$_POST['phone'],
            'password'=>md5($_POST['password']),
            'type'=>'admin',
        ];
            $user = $this->model('UserModel');
            $user->insertUser($data);
            $_SESSION['success'] = "Add user successfully";
            $response = new Response();
            $response->redirect('admin/usercontroller');
        }
    }
}
