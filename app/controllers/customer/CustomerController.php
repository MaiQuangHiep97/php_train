<?php
class CustomerController extends Controller
{
    public $model;
    public $data = array();
    public function __construct()
    {
        $this->model = $this->model('UserModel');
    }
    public function index()
    {
        $this->data['errors'] = Session::flash('errors');
        $this->data['old'] = Session::flash('old');
        $this->render('clients/customer/login', $this->data);
    }
    public function login()
    {
        try {
            //Validate form
            $response = new Response();
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
                    $response->redirect('customer/login');
                }
            } else {
                $response->redirect('customer/login');
            }
            //Check Login
            if (!empty($_POST['email'] && $_POST['password'] && $_POST['type'])) {
                $user=$this->model->getCustomer();
                if (md5($_POST['password'])==$user['password'] && $_POST['type']==$user['type']) {
                    $_SESSION['is_login']=true;
                    $_SESSION['customer_login']=$user;
                    if (!empty($_POST['remember'])) {
                        setcookie('is_login', $_SESSION['is_login'], time() + (3600));
                        setcookie('customer_login', $_SESSION['customer_login']['id'], time() + (3600));
                    }
                    $response->redirect('');
                } else {
                    $_SESSION['error'] = "Incorrect account or password information";
                    $response->redirect('customer/login');
                }
            }
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function logout()
    {
        if (isset($_COOKIE['is_login'])&&isset($_COOKIE['customer_login'])) {
            setcookie('is_login', $_SESSION['is_login'], time() - (3600));
            setcookie('customer_login', $_SESSION['customer_login']['id'], time() - (3600));
        }
        unset($_SESSION['is_login']);
        unset($_SESSION['customer_login']);
        $response = new Response();
        $response->redirect('customer/login');
    }
    public function getRegister()
    {
        $this->data['errors'] = Session::flash('errors');
        $this->data['old'] = Session::flash('old');
        $this->render('clients/customer/register', $this->data);
    }
    public function postRegister()
    {
        try {
            //Validate form
            $response = new Response();
            $request = new Request();
            if ($request->isPost()) {
                $request->rules([
                    'email'=>'required|email',
                    'password'=>'required|min:3',
                    'passwordConfirm'=>'required|match:password'
                ]);
                $request->message([
                    'email.required'=>'Please enter email',
                    'email.email'=>'Please enter valid email!',
                    'password.required'=>'Please enter password',
                    'password.min'=>'Password must be more than 3 characters',
                    'passwordConfirm.required'=>'Please enter confirm password',
                    'passwordConfirm.match'=>'Confirm password does not match',
                ]);
                $validate = $request->validate();
                if (!$validate) {
                    Session::flash('errors', $request->errors());
                    Session::flash('old', $request->getFields());
                    $response->redirect('customer/register');
                }
            } else {
                $response->redirect('customer/register');
            }
            //Check register
            if ($this->model->getCustomer()) {
                $_SESSION['error']="Email already exists";
                $response->redirect('customer/register');
            } else {
                $data = [
                    'name'=>$_POST['username'],
                    'email'=>$_POST['email'],
                    'password'=>md5($_POST['password']),
                    'type'=>'user'
                ];
                $this->model->insertUser($data);
                $id = $this->db->lastInsertID();
                $data = [
                    'user_id'=>$id
                ];
                if ($this->db->table('tbl_customers')->insert($data)) {
                    $_SESSION['success']="Register User success";
                    $response->redirect('');
                }
            }
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function getChange()
    {
        if ($this->authCustomer()) {
            $this->data['errors'] = Session::flash('errors');
            $this->data['customer'] = $_SESSION['customer_login'];
            $this->render('clients/customer/change', $this->data);
        } else {
            $response = new Response();
            $response->redirect('admin/login');
        }
    }
    public function postChange()
    {
        try {
            if ($this->authCustomer()) {
                // Validate form
                $response = new Response();
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
                        $response->redirect('customer/change');
                    }
                } else {
                    $response->redirect('customer/change');
                }
                // Change Password
                if (!empty($_POST['password'])&&$_POST['password']==$_POST['confirm_password']) {
                    $data = [
                    'password'=>md5($_POST['password'])
                ];
                    $this->model->updateCustomer($data);
                    $_SESSION['success'] = "Changed password successfully";
                    $response->redirect('');
                }
            } else {
                $response = new Response();
                $response->redirect('customer/login');
            }
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function info()
    {
        if ($this->authCustomer()) {
            $this->data['errors'] = Session::flash('errors');
            $this->data['old'] = Session::flash('old');
            $this->data['customer'] = $this->db->table('tbl_customers')
        ->join('tbl_users', 'tbl_users.id=tbl_customers.user_id')
        ->select('tbl_customers.id as id_customer, tbl_users.id as id_user, name, email, phone, gender, address')
        ->where('user_id', '=', $_SESSION['customer_login']['id'])->get();
        } else {
            $response = new Response();
            $response->redirect('customer/login');
        }
        $this->render('clients/customer/info', $this->data);
    }
    public function postInfo()
    {
        try {
            //Validate form
            $response = new Response();
            $request = new Request();
            if ($this->authCustomer()) {
                $request->rules([
                    'phone'=>'required|regex:/^[0-9]*$/',
                    'address'=>'required',
                    'gender'=>'required',
                    
                ]);
                $request->message([
                    'phone.required'=>'Please enter phone',
                    'phone.regex'=>'Please enter valid phone!',
                    'address.required'=>'Please enter address!',
                    'gender.required'=>'Please select gender!',
                ]);
                $validate = $request->validate();
                if (!$validate) {
                    Session::flash('errors', $request->errors());
                    Session::flash('old', $request->getFields());
                    $response->redirect('customer/info');
                }
            
                //Update
                $data = [
                    'phone'=>$_POST['phone'],
                ];
                $this->model->updateCustomer($data);
                $data = [
                    'address'=>$_POST['address'],
                    'gender'=>$_POST['gender'],
                ];
                $this->db->table('tbl_customers')->where('user_id', '=', $_POST['id'])->update($data);
                $response->redirect('');
            } else {
                $response = new Response();
                $response->redirect('customer/login');
            }
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
}
