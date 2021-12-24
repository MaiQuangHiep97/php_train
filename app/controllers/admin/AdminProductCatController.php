<?php
class AdminProductCatController extends Controller
{
    public $model;
    public $data = array();
    public function __construct()
    {
        if (!$this->auth()) {
            $response = new Response();
            $response->redirect('admin/login');
        }
        $this->model = $this->model('ProductCatModel');
    }
    public function index()
    {
        try {
            $this->data['user'] = $_SESSION['user_login']['name'];
            $this->data['cats'] = $this->model->getAll();
            $limit = 5;
            if (count($this->data['cats'])>$limit) {
                $data = $this->pagi($this->data['cats'], $limit);
                if ($data['total']>0) {
                    $this->data['cats'] = $this->db->table('tbl_product_cats')->limit($limit, $data['start'])->get();
                }
                $this->data['pagination']=$data['button_pagination'];
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
            $this->data['category'] = $this->model->find($id);
            $this->data['errors'] = Session::flash('errors');
            $this->render('admins/cat/edit', $this->data);
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function update()
    {
        try {
            //Validate form
            $id = $_POST['cat_id'];
            $response = new Response();
            $request = new Request();
            if ($request->isPost()) {
                $request->rules([
                    'category'=>'required',
                ]);
                $request->message([
                    'category.required'=>'Please enter category',
                ]);
                $validate = $request->validate();
                if (!$validate) {
                    Session::flash('errors', $request->errors());
                    $response->redirect('admin/cat/edit?id='.$id);
                }
            } else {
                $response->redirect('admin/cat/edit?id='.$id);
            }
            //Update
            if (!empty($_POST['category'])) {
                $data = [
                    'cat_name'=>$_POST['category'],
                    'user_id'=>$_SESSION['user_login']['id']
                ];
                $this->model->updateCat($id, $data);
                $_SESSION['success'] = "Update Category successfully";
                $response->redirect('admin/cat/list');
            }
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function store()
    {
        try {
            //Validate form
            $response = new Response();
            $request = new Request();
            if ($request->isPost()) {
                $request->rules([
                    'category'=>'required',
                ]);
                $request->message([
                    'category.required'=>'Please enter category',
                ]);
                $validate = $request->validate();
                if (!$validate) {
                    Session::flash('errors', $request->errors());
                    $response->redirect('admin/cat/list');
                }
            } else {
                $response->redirect('admin/cat/list');
            }
            // Store
            if (!empty($_POST['category'])) {
                $data = [
                            'cat_name'=>$_POST['category'],
                            'user_id'=>$_SESSION['user_login']['id']
                        ];
                $this->model->insertCat($data);
                $_SESSION['success'] = "Add category successfully";
                $response->redirect('admin/cat/list');
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
            $this->model->deleteCat($id);
            $_SESSION['success'] = "Delete category successfully";
            $response->redirect('admin/cat/list');
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
}
