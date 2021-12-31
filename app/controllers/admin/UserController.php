<?php
class UserController extends Controller
{
    public $data = array();
    public $response;
    public $repoUser;
    public $repoCustomer;
    public function __construct()
    {
        $this->repoUser = new UserRepository();
        $this->repoCustomer = new CustomerRepository();
        $this->response = new Response();
        if (!$this->auth()) {
            $this->response->redirect('admin-login');
        }
    }
    public function getList($type)
    {
        $this->data['user'] = $_SESSION['user_login']['name'];
        $this->data['type'] = $type;
        if (!empty($_GET['key']) && isset($type)) {
            $this->data = $this->search($type);
        } elseif (!empty($type)) {
            $this->data['users'] = $this->repoUser->getList($type);
            $limit = 10;
            if (count($this->data['users']) > $limit) {
                $data = Paginator::pagi($this->data['users'], $limit);
                if ($data['total'] > 0) {
                    $this->data['users'] = $this->repoUser->getPagi($limit, $data['start'], $type);
                }
                $this->data['pagination'] = $data['button_pagination'];
            }
        }
        $this->data['type'] = $type;
        $this->render('admins/user/list', $this->data);
    }
    public function search($type)
    {
        if (isset($_GET['key'])) {
            $this->data['key'] = $_GET['key'];
            $limit = 10;
            $this->data['users'] = $this->repoUser->getSearch($_GET['key'], $type);
            if (count($this->data['users'])>$limit) {
                $data = Paginator::pagi($this->data['users'], $limit);
                if ($data['total']>0) {
                    $this->data['users'] = $this->repoUser->getSearchPagi($limit, $data['start'], $_GET['key'], $type);
                }
                $this->data['pagination'] = $data['button_pagination'];
            }
            return $this->data;
        }
    }
    public function edit($id)
    {
        try {
            $this->data['user'] = $this->repoUser->find($id);
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
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
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
            'password.regex'=>'Minimum eight characters, at least one uppercase letter, one lowercase letter and one number:',
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
                $this->response->redirect('admin-user-edit-'.$id);
            }
            //Update
            if (!empty($_POST)) {
                $user = $this->repoUser->find($id);
                $data = [
                    'name' => $_POST['username'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'password' => md5($_POST['password']),
                    ];
                if ($_POST['email'] == $user['email']) {
                    $this->repoUser->update($id, $data);
                    $_SESSION['success'] = "Update successfully";
                    $this->response->redirect('admin-list-admin.html');
                } else {
                    if ($this->repoUser->getUser($_POST['email'], $user['type'])) {
                        $_SESSION['error'] = "Email already exists";
                        $this->response->redirect('admin-user-edit-'.$id);
                    } else {
                        $this->repoUser->update($id, $data);
                        $_SESSION['success'] = "Update successfully";
                        $this->response->redirect('admin-list-admin.html');
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
            'username' => 'required|max:20',
            'email' => 'required|email',
            'phone' => 'required|regex:/^[0-9]*$/',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
            'type' => 'required'
        ]);
        $request->message([
            'username.required' => 'Please enter username',
            'username.min' => 'Username up to 20 characters',
            'email.required' => 'Please enter email',
            'email.email' => 'Please enter valid email!',
            'phone.required' => 'Please enter phone',
            'phone.regex' => 'Please enter valid phone',
            'password.required' => 'Please enter password',
            'password.regex'=>'Minimum eight characters, at least one uppercase letter, one lowercase letter and one number:',
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
                $this->response->redirect('admin-user-add');
            }
            // Store
            if (!empty($_POST)) {
                if ($this->repoUser->getUser($_POST['email'], $_POST['type'])) {
                    $_SESSION['error'] = "Email already exists";
                    $this->response->redirect('admin-user-add');
                } else {
                    $data = [
                            'name' => $_POST['username'],
                            'email' => $_POST['email'],
                            'phone' => $_POST['phone'],
                            'password' => md5($_POST['password']),
                            'type' => $_POST['type'],
                        ];
                    $this->repoUser->insert($data);
                    $id = $this->db->lastInsertID();
                    $data = [
                    'user_id' => $id
                        ];
                    if ($this->repoCustomer->insert($data)) {
                        $_SESSION['success'] = "Add user successfully";
                        if ($_POST['type'] == 'admin') {
                            $this->response->redirect('admin-list-admin.html');
                        }
                        $this->response->redirect('admin-list-user.html');
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
            $id = $_GET['id'];
            if ($id !== $_SESSION['user_login']['id']) {
                $this->repoUser->delete($id);
                $this->repoCustomer->deleteWithUser($id);
                $_SESSION['success'] = "Delete user successfully";
                $this->response->redirect('admin-list-admin.html');
            }
            $_SESSION['error'] = "Can not delele this user";
            $this->response->redirect('admin-list-admin.html');
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
}
