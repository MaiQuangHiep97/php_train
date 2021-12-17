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
    public function index()
    {
        try {
            $users = $this->model('UserModel');
            $this->data['user'] = $_SESSION['user_login']['name'];
            $this->data['users'] = $users->getAll();
            $this->render('admins/user/list', $this->data);
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function edit()
    {
        try {
            $id = $_GET['id'];
            $users = $this->model('UserModel');
            $this->data['user'] = $users->find($id);
            $this->data['errors'] = Session::flash('errors');
            $this->data['old'] = Session::flash('old');
            $this->render('admins/user/edit', $this->data);
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function update()
    {
        try {
            //Validate form
            $id = $_POST['id'];
            $request = new Request();
            if ($request->isPost()) {
                $request->rules([
                    'username'=>'required|max:20|regex:/^[a-zA-z0-9]*$/',
                    'phone'=>'required|regex:/^([+]?[\s0-9]+)?(\d{3}|[(]?[0-9]+[)])?([-]?[\s]?[0-9])+$/',
                ]);
                $request->message([
                    'username.required'=>'Please enter username',
                    'username.regex'=>'Please enter valid username',
                    'username.min'=>'Username up to 20 characters',
                    'phone.required'=>'Please enter phone',
                    'phone.regex'=>'Please enter valid phone',
                ]);
                $validate = $request->validate();
                if (!$validate) {
                    Session::flash('errors', $request->errors());
                    Session::flash('old', $request->getFields());
                    $response = new Response();
                    $response->redirect('admin/usercontroller/edit?id='.$id);
                }
            } else {
                $response = new Response();
                $response->redirect('admin/usercontroller/edit?id='.$id);
            }
            //Update
            if (isset($_POST)) {
                $data = [
                    'name'=>$_POST['username'],
                    'phone'=>$_POST['phone']
                ];
                $this->db->table('tbl_users')->where('id', '=', $_POST['id'])->update($data);
                $_SESSION['success'] = "Update successfully";
                $response = new Response();
                $response->redirect('admin/usercontroller');
            }
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function add()
    {
        $this->data['errors'] = Session::flash('errors');
        $this->data['old'] = Session::flash('old');
        $this->render('admins/user/add', $this->data);
    }
    public function store()
    {
        try {
            //Validate form
            $request = new Request();
            if ($request->isPost()) {
                $request->rules([
                    'username'=>'required|max:20',
                    'email'=>'required|email',
                    'phone'=>'required',
                    'password'=>'required|min:3'
                ]);
                $request->message([
                    'username.required'=>'Please enter username',
                    'username.min'=>'Username up to 20 characters',
                    'email.required'=>'Please enter email',
                    'email.email'=>'Please enter valid email!',
                    'phone.required'=>'Please enter phone',
                    'password.required'=>'Please enter password',
                    'password.min'=>'Password must be more than 3 characters',
                ]);
                $validate = $request->validate();
                if (!$validate) {
                    Session::flash('errors', $request->errors());
                    Session::flash('old', $request->getFields());
                    $response = new Response();
                    $response->redirect('admin/usercontroller/add');
                }
            } else {
                $response = new Response();
                $response->redirect('admin/usercontroller/add');
            }
            // Store
            if (isset($_POST)) {
                $response = new Response();
                if ($data = $this->db->table('tbl_users')->where('email', '=', $_POST['email'])->where('type', '=', 'admin')->get()) {
                    $_SESSION['error'] = "Email already exists";
                    $response->redirect('admin/usercontroller/add');
                } else {
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
                    $response->redirect('admin/usercontroller');
                }
            }
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function delete()
    {
        try {
            $response = new Response();
            $id = $_GET['id'];
            if ($id !== $_SESSION['user_login']['id']) {
                $user = $this->model('UserModel');
                $user->deleteUser($id);
                $_SESSION['success'] = "Delete user successfully";
                $response->redirect('admin/usercontroller');
            }
            $_SESSION['error'] = "Can not delele this user";
            $response->redirect('admin/usercontroller');
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
}
