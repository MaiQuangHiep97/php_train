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
        if ($this->auth()) {
            $response = new Response();
            $response->redirect('admin/dashboardcontroller/');
        } else {
            $this->data['errors'] = Session::flash('errors');
            $this->data['old'] = Session::flash('old');
            //var_dump($this->data['errors']);
            $this->render('admins/authenticate/login', $this->data);
        }
    }
    public function login()
    {
        try {
            //Validate form
            $request = new Request();
            if ($request->isPost()) {
                $request->rules([
                    'email'=>'required|email',
                    'password'=>'required|min:3'
                ]);
                $request->message([
                    'email.required'=>'Please enter email',
                    'email.email'=>'Please enter valid email!',
                    'password.required'=>'Please enter password',
                    'password.min'=>'Password must be more than 3 characters',
                ]);
                $validate = $request->validate();
                if (!$validate) {
                    Session::flash('errors', $request->errors());
                    Session::flash('old', $request->getFields());
                    $response = new Response();
                    $response->redirect('admin/authcontroller/');
                }
            } else {
                $response = new Response();
                $response->redirect('admin/authcontroller/');
            }
            //Check Login
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
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
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
    public function getChange()
    {
        if ($this->auth()) {
            $this->data['errors'] = Session::flash('errors');
            $this->data['user'] = $_SESSION['user_login'];
            $this->render('admins/authenticate/change', $this->data);
        } else {
            $response = new Response();
            $response->redirect('admin/authcontroller/');
        }
    }
    public function postChange()
    {
        try {
            if ($this->auth()) {
                // Validate form
                $request = new Request();
                if ($request->isPost()) {
                    $request->rules([
                        'password'=>'required|min:3',
                        'confirm_password'=>'required|match:password'
                    ]);
                    $request->message([
                        'password.required'=>'Please enter password',
                        'password.min'=>'Password must be more than 3 characters',
                        'confirm_password.required'=>'Please enter confirm password',
                        'confirm_password.match'=>'Confirm password does not match',
                    ]);
                    $validate = $request->validate();
                    if (!$validate) {
                        Session::flash('errors', $request->errors());
                        $response = new Response();
                        $response->redirect('admin/authcontroller/getChange');
                    }
                } else {
                    $response = new Response();
                    $response->redirect('admin/authcontroller/getChange');
                }
                // Change Password
                if (!empty($_POST['password'])&&$_POST['password']==$_POST['confirm_password']) {
                    $data = [
                    'password'=>md5($_POST['password'])
                ];
                    $user = $this->model('UserModel');
                    $user->updateUser($data);
                    $_SESSION['success'] = "Changed password successfully";
                    $response = new Response();
                    $response->redirect('admin/dashboardcontroller');
                }
            } else {
                $response = new Response();
                $response->redirect('admin/authcontroller/');
            }
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
}
