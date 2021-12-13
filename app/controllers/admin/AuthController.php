<?php
class AuthController extends Controller
{
    public $model;
    public $data = array();
    public function __construct()
    {
        $this->model = $this->model('UserModel');
    }
    public function index()
    {
        if (isset($_COOKIE['is_login'])&&isset($_COOKIE['user_login'])) {
            $response = new Response();
            $response->redirect('admin/dashboardcontroller/');
        }
        $this->render('admins/login');
    }
    public function login()
    {
        if (!empty($_POST['email'] && $_POST['password'])) {
            $user = $this->model('UserModel');
            $this->data['user']=$user->getUser();
            $response = new Response();
            if (md5($_POST['password'])==$this->data['user']['password']) {
                $_SESSION['is_login']=true;
                $_SESSION['user_login']=$this->data['user'];
                if (!empty($_POST['remember'])) {
                    setcookie('is_login', $_SESSION['is_login'], time() + (3600));
                    setcookie('user_login', $_SESSION['user_login']['id'], time() + (3600));
                }
                $response->redirect('admin/dashboardcontroller/');
            } else {
                $_SESSION['error'] = "Incorrect account or password information";
                $response->redirect('admin/authcontroller/');
            }
        }
    }
    public function logout()
    {
        if (isset($_COOKIE['is_login'])&&isset($_COOKIE['user_login'])) {
            setcookie('is_login', $_SESSION['is_login'], time() - (3600));
            setcookie('user_login', $_SESSION['user_login']['id'], time() - (3600));
        }
        unset($_SESSION['is_login']);
        unset($_SESSION['user_login']);
        $response = new Response();
        $response->redirect('admin/authcontroller/');
    }
}
