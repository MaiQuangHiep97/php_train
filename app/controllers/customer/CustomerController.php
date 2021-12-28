<?php
class CustomerController extends Controller
{
    public $repoUser;
    public $repoCustomer;
    public $data = array();
    public $response;
    public function __construct()
    {
        $this->response = new Response();
        $this->repoUser = new UserRepository();
        $this->repoCustomer = new CustomerRepository();
    }
    public function index()
    {
        $this->data['errors'] = Session::flash('errors');
        $this->data['old'] = Session::flash('old');
        $this->render('clients/customer/login', $this->data);
    }
    public function validateLogin($request)
    {
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
        return $validate;
    }
    public function login()
    {
        try {
            //Validate form
            $request = new Request();
            if (!$this->validateLogin($request)) {
                Session::flash('errors', $request->errors());
                Session::flash('old', $request->getFields());
                $this->response->redirect('customer/login');
            }
            //Check Login
            if (!empty($_POST['email'] && $_POST['password'] && $_POST['type'])) {
                $user = $this->repoUser->getUser($_POST['email'], $_POST['type']);
                if (md5($_POST['password']) == $user['password'] && $_POST['type'] == $user['type']) {
                    $_SESSION['is_login']=true;
                    $_SESSION['customer_login']=$user;
                    if (!empty($_POST['remember'])) {
                        setcookie('is_login', $_SESSION['is_login'], time() + (3600));
                        setcookie('customer_login', $_SESSION['customer_login']['id'], time() + (3600));
                    }
                    $this->response->redirect('');
                } else {
                    $_SESSION['error'] = "Incorrect account or password information";
                    $this->response->redirect('customer/login');
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
        $this->response->redirect('customer/login');
    }
    public function getRegister()
    {
        $this->data['errors'] = Session::flash('errors');
        $this->data['old'] = Session::flash('old');
        $this->render('clients/customer/register', $this->data);
    }
    public function validateRegister($request)
    {
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
        return $validate;
    }
    public function postRegister()
    {
        try {
            //Validate form
            $request = new Request();
            if (!$this->validateRegister($request)) {
                Session::flash('errors', $request->errors());
                Session::flash('old', $request->getFields());
                $this->response->redirect('customer/register');
            }
            //Check register
            if ($this->repoUser->getUser($_POST['email'], $_POST['type'])) {
                $_SESSION['error']="Email already exists";
                $this->response->redirect('customer/register');
            } else {
                $data = [
                    'name'=>$_POST['username'],
                    'email'=>$_POST['email'],
                    'password'=>md5($_POST['password']),
                    'type'=>'user'
                ];
                $this->repoUser->insert($data);
                $id = $this->db->lastInsertID();
                $data = [
                    'user_id'=>$id
                ];
                if ($this->repoCustomer->insert($data)) {
                    $_SESSION['success']="Register User success";
                    $this->response->redirect('customer/login');
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
            $this->response->redirect('customer/login');
        }
    }
    public function validateChange($request)
    {
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
        return $validate;
    }
    // public function postChange()
    // {
    //     try {
    //         if ($this->authCustomer()) {
    //             // Validate form
    //             $request = new Request();
    //             if (!$this->validateChange($request)) {
    //                 Session::flash('errors', $request->errors());
    //                 $this->response->redirect('customer/change');
    //             }
    //             // Change Password
    //             $id = $_SESSION['customer_login']['id'];
    //             if (!empty($_POST['password'])&&$_POST['password']==$_POST['confirm_password']) {
    //                 $data = [
    //                 'password'=>md5($_POST['password'])
    //             ];
    //                 $this->repoCustomer->update($id, $data);
    //                 $_SESSION['success'] = "Changed password successfully";
    //                 $this->response->redirect('');
    //             }
    //         } else {
    //             $this->response->redirect('customer/login');
    //         }
    //     } catch (PDOException $e) {
    //         $error_message = $e->getMessage();
    //         echo "Database error: $error_message";
    //     }
    // }
    public function info()
    {
        if ($this->authCustomer()) {
            $this->data['errors'] = Session::flash('errors');
            $this->data['old'] = Session::flash('old');
            $this->data['customer'] = $this->repoCustomer->getCustomer($_SESSION['customer_login']['id']);
        } else {
            $this->response->redirect('customer/login');
        }
        $this->render('clients/customer/info', $this->data);
    }
    public function validateInfo($request)
    {
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
        return $validate;
    }
    public function postInfo()
    {
        try {
            //Validate form
            $request = new Request();
            if ($this->authCustomer()) {
                if (!$this->validateInfo($request)) {
                    Session::flash('errors', $request->errors());
                    Session::flash('old', $request->getFields());
                    $this->response->redirect('customer/info');
                }
                //Update
                $data = [
                    'phone'=>$_POST['phone'],
                ];
                $id = $_POST['id'];
                $this->repoUser->update($id, $data);
                $data = [
                    'address'=>$_POST['address'],
                    'gender'=>$_POST['gender'],
                ];
                $this->repoCustomer->updateWithUserId($id, $data);
                $this->response->redirect('');
            } else {
                $this->response->redirect('customer/login');
            }
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
}
