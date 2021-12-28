<?php
class UserController extends Controller
{
    public $model;
    public $data = array();
    public $response;
    public $repoUser;
    public function __construct()
    {
        $this->repoUser = new UserRepository();
        $this->response = new Response();
        if (!$this->auth()) {
            $this->response->redirect('admin/login');
        }
        $this->model = $this->model('UserModel');
    }
    public function getList($type)
    {
        try {
            $this->data['users'] = $this->repoUser->getList($type);
            echo '<pre>';
            print_r($this->data['users']);
            // $this->data['user'] = $_SESSION['user_login']['name'];
            // if (!empty($type)) {
            //     if ($type == 1) {
            //         $type = 'admin';
            //     } elseif ($type == 2) {
            //         $type = 'user';
            //     }
            //     $this->data['users'] = $this->repoUser->getList($type);
            //     $limit = 10;
            //     if (count($this->data['users']) > $limit) {
            //         $data = Paginator::pagi($this->data['users'], $limit);
            //         if ($data['total'] > 0) {
            //             $this->data['users'] = $this->model->getPagi($limit, $data['start'], $type);
            //         }
            //         $this->data['pagination'] = $data['button_pagination'];
            //     }
            //     $this->data['type'] = $type;
            //     $this->render('admins/user/list', $this->data);
            // }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function edit()
    {
        try {
            $id = $_GET['id'];
            $this->data['user'] = $this->model->find($id);
            $this->data['errors'] = Session::flash('errors');
            $this->data['old'] = Session::flash('old');
            $this->render('admins/user/edit', $this->data);
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function validateEdit($request)
    {
        $request->rules([
            'username' => 'required|max:20|regex:/^[^0-9]*$/',
            'email' => 'required|email',
            'phone' => 'required|regex:/^[0-9]*$/',
            'password' => 'required|min:3',
        ]);
        $request->message([
            'username.required' => 'Please enter username',
            'username.regex' => 'Please enter valid username',
            'username.min' => 'Username up to 20 characters',
            'email.required' => 'Please enter email',
            'email.email' => 'Please enter valid email!',
            'phone.required' => 'Please enter phone',
            'phone.regex' => 'Please enter valid phone',
            'password.required' => 'Please enter password',
            'password.min' => 'Password must be more than 3 characters',
        ]);
        $validate = $request->validate();
        return $validate;
    }
    public function update()
    {
        try {
            //Validate form
            $id = $_POST['id'];
            $request = new Request();
            if (!$this->validateEdit($request)) {
                Session::flash('errors', $request->errors());
                Session::flash('old', $request->getFields());
                $this->response->redirect('admin/user/edit?id='.$id);
            }
            //Update
            if (!empty($_POST)) {
                $user = $this->model->find($id);
                $data = [
                    'name' => $_POST['username'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'password' => md5($_POST['password']),
                    ];
                if ($_POST['email'] == $user['email']) {
                    $this->db->table('tbl_users')->where('id', '=', $_POST['id'])->update($data);
                    $_SESSION['success'] = "Update successfully";
                    $this->response->redirect('admin/list/type-1');
                } else {
                    if ($this->db->table('tbl_users')->where('email', '=', $_POST['email'])->where('type', '=', $user['type'])->get()) {
                        $_SESSION['error'] = "Email already exists";
                        $this->response->redirect('admin/user/edit?id='.$id);
                    } else {
                        $this->db->table('tbl_users')->where('id', '=', $_POST['id'])->update($data);
                        $_SESSION['success'] = "Update successfully";
                        $this->response->redirect('admin/list/type-1');
                    }
                }
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
    public function validateAdd($request)
    {
        $request->rules([
            'username' => 'required|max:20|regex:/^[^0-9]*$/',
            'email' => 'required|email',
            'phone' => 'required|regex:/^[0-9]*$/',
            'password' => 'required|min:3',
            'type' => 'required'
        ]);
        $request->message([
            'username.required' => 'Please enter username',
            'username.regex' => 'Please enter valid username',
            'username.min' => 'Username up to 20 characters',
            'email.required' => 'Please enter email',
            'email.email' => 'Please enter valid email!',
            'phone.required' => 'Please enter phone',
            'phone.regex' => 'Please enter valid phone',
            'password.required' => 'Please enter password',
            'password.min' => 'Password must be more than 3 characters',
            'type' => 'Please select roles'
        ]);
        $validate = $request->validate();
        return $validate;
    }
    public function store()
    {
        try {
            //Validate form
            $request = new Request();
            if (!$this->validateAdd($request)) {
                Session::flash('errors', $request->errors());
                Session::flash('old', $request->getFields());
                $this->response->redirect('admin/user/add');
            }
            // Store
            if (!empty($_POST)) {
                if ($this->db->table('tbl_users')->where('email', '=', $_POST['email'])->where('type', '=', $_POST['type'])->get()) {
                    $_SESSION['error'] = "Email already exists";
                    $this->response->redirect('admin/user/add');
                } else {
                    $data = [
                            'name' => $_POST['username'],
                            'email' => $_POST['email'],
                            'phone' => $_POST['phone'],
                            'password' => md5($_POST['password']),
                            'type' => $_POST['type'],
                        ];
                    $this->model->insertUser($data);
                    $id = $this->db->lastInsertID();
                    $data = [
                    'user_id' => $id
                        ];
                    if ($this->db->table('tbl_customers')->insert($data)) {
                        $_SESSION['success'] = "Add user successfully";
                        if ($_POST['type'] == 'admin') {
                            $this->response->redirect('admin/list/type-1');
                        }
                        $this->response->redirect('admin/list/type-2');
                    }
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
                $this->model->deleteUser($id);
                $this->db->table('tbl_customers')->where('user_id', '=', $id)->delete();
                $_SESSION['success'] = "Delete user successfully";
                $response->redirect('admin/list/type-1');
            }
            $_SESSION['error'] = "Can not delele this user";
            $response->redirect('admin/list/type-1');
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
}
