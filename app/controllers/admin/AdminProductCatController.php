<?php
class AdminProductCatController extends Controller
{
    public $data = array();
    public $response;
    public $repoCate;
    public function __construct()
    {
        $this->response = new Response();
        if (!$this->auth()) {
            $this->response->redirect('admin/login');
        }
        $this->repoCate = new ProductCatRepository();
    }
    public function index()
    {
        try {
            $this->data['user'] = $_SESSION['user_login']['name'];
            $this->data['cats'] = $this->repoCate->getAll();
            $limit = 5;
            if (count($this->data['cats']) > $limit) {
                $data = Paginator::pagi($this->data['cats'], $limit);
                if ($data['total'] > 0) {
                    $this->data['cats'] = $this->repoCate->pagiGet($limit, $data['start']);
                }
                $this->data['pagination'] = $data['button_pagination'];
            }
            $this->data['errors'] = Session::flash('errors');
            $this->render('admins/cat/list', $this->data);
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function edit()
    {
        try {
            $id = $_GET['id'];
            $this->data['user'] = $_SESSION['user_login']['name'];
            $this->data['category'] = $this->repoCate->find($id);
            $this->data['errors'] = Session::flash('errors');
            $this->render('admins/cat/edit', $this->data);
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function validateCate($request)
    {
        $request->rules([
                'category' => 'required',
            ]);
        $request->message([
                'category.required' => 'Please enter category',
            ]);
        $validate = $request->validate();
        return $validate;
    }
    public function update()
    {
        try {
            //Validate form
            $id = $_POST['cat_id'];
            $request = new Request();
            if (!$this->validateCate($request)) {
                Session::flash('errors', $request->errors());
                $this->response->redirect('admin/cat/edit?id='.$id);
            }
            //Update
            if (!empty($_POST['category'])) {
                $category = $this->repoCate->find($id);
                if (($_POST['category'] == $category['cat_name']) || (!$this->checkCat($_POST['category']))) {
                    $data = [
                        'cat_name' => $_POST['category'],
                        'user_id' => $_SESSION['user_login']['id']
                    ];
                    $this->repoCate->update($id, $data);
                    $_SESSION['success'] = "Update Category successfully";
                    $this->response->redirect('admin/cat/list');
                } else {
                    $_SESSION['error'] = "Category already exists";
                    $this->response->redirect('admin/cat/list');
                }
            }
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function checkCat($name)
    {
        if ($this->repoCate->getCat($name)) {
            return true;
        } else {
            return false;
        }
    }
    public function store()
    {
        try {
            //Validate form
            $request = new Request();
            if (!$this->validateCate($request)) {
                Session::flash('errors', $request->errors());
                $this->response->redirect('admin/cat/list');
            }
            // Store
            if (!empty($_POST['category'])) {
                if (!$this->checkCat($_POST['category'])) {
                    $data = [
                        'cat_name' => $_POST['category'],
                        'user_id' => $_SESSION['user_login']['id']
                    ];
                    $this->repoCate->insert($data);
                    $_SESSION['success'] = "Add category successfully";
                    $this->response->redirect('admin/cat/list');
                } else {
                    $_SESSION['error'] = "Category already exists";
                    $this->response->redirect('admin/cat/list');
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
            $this->repoCate->delete($id);
            $_SESSION['success'] = "Delete category successfully";
            $this->response->redirect('admin/cat/list');
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
}
