<?php
class AdminProductController extends Controller
{
    public $model;
    public $data = array();
    public $response;
    public function __construct()
    {
        $this->response = new Response();
        if (!$this->auth()) {
            $this->response->redirect('admin/login');
        }
        $this->model = $this->model('ProductModel');
    }
    public function index()
    {
        $this->data['user'] = $_SESSION['user_login']['name'];
        $this->data['products'] = $this->model->getAll();
        $limit = 8;
        if (count($this->data['products'])>$limit) {
            $data = Paginator::pagi($this->data['products'], $limit);
            if ($data['total']>0) {
                $this->data['products'] = $this->model->getPagiCms($limit, $data['start']);
            }
            $this->data['pagination'] = $data['button_pagination'];
        }
        $this->render('admins/product/list', $this->data);
    }
    public function add()
    {
        $cats = $this->model('ProductCatModel');
        $this->data['errors'] = Session::flash('errors');
        $this->data['old'] = Session::flash('old');
        $this->data['cats'] = $cats->getALL();
        $this->data['user'] = $_SESSION['user_login']['name'];
        $this->render('admins/product/add', $this->data);
    }
    public function validateProduct($request)
    {
        $request->rules([
                'product_name' => 'required',
                'product_desc' => 'required',
                'product_detail' => 'required',
                'product_price' => 'required|regex:/^[0-9]*$/',
                'product_cat' => 'required',
            ]);
        $request->message([
                'product_name.required' => 'Please enter product name',
                'product_desc.required' => 'Please enter description',
                'product_detail.required' => 'Please enter detail',
                'product_price.required' => 'Please enter price',
                'product_price.regex' => 'Please enter valid price!',
                'product_cat.required' => 'Please select category',
            ]);
        $validate = $request->validate();
        return $validate;
    }
    public function validateFile($file_name)
    {
        $type = pathinfo($file_name, PATHINFO_EXTENSION);
        $type_allow = array('png','jpg','jpeg','gift');
        if (!in_array(strtolower($type), $type_allow)) {
            return false;
        }
        return true;
    }
    public function store()
    {
        try {
            $request = new Request();
            if (!$this->validateProduct($request)) {
                Session::flash('errors', $request->errors());
                Session::flash('old', $request->getFields());
                $this->response->redirect('admin/product/add');
            }
            if (!empty($_POST) && !empty($_FILES)) {
                $file_name = $_FILES['product_thumb']['name'];
                if (!$this->validateFile($file_name)) {
                    $this->response->redirect('admin/product/add');
                } else {
                    $upload_dir = 'public/uploads/products/';
                    $file_name = $this->handleFile($file_name, $upload_dir);
                    move_uploaded_file($_FILES['product_thumb']['tmp_name'], $upload_dir.$file_name);
                    $data = [
                        'product_name' => $_POST['product_name'],
                        'product_des' => $_POST['product_desc'],
                        'product_price' => $_POST['product_price'],
                        'product_detail' => $_POST['product_detail'],
                        'product_thumb' => $file_name,
                        'cat_id' => $_POST['product_cat'],
                        'user_id' => $_SESSION['user_login']['id']
                ];
                    $this->model->insertProduct($data);
                    $id = $this->db->lastInsertID();
                }
                if (isset($id)) {
                    $files = $_FILES['product_images'];
                    $filenames = $files['name'];
                    $upload_dir = 'public/uploads/images/';
                    foreach ($filenames as $key => $value) {
                        $file_name = $value;
                        if (!$this->validateFile($file_name)) {
                            $this->response->redirect('admin/product/add');
                        } else {
                            $file_name = $this->handleFile($file_name, $upload_dir);
                            $upload_file = $upload_dir.$file_name;
                            move_uploaded_file($files['tmp_name'][$key], $upload_file);
                            $image = [
                            'image' => $file_name,
                            'product_id' => $id
                        ];
                            $this->db->table('tbl_product_images')->insert($image);
                        }
                    }
                }
                $_SESSION['success'] = "Add product successfully";
                $this->response->redirect('admin/product/list');
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
            $product = $this->model->getProduct($id);
            $upload_dir='public/uploads/products/';
            if (file_exists($upload_dir.$product['product_thumb'])) {
                unlink($upload_dir.$product['product_thumb']);
            }
            $this->model->deleteProduct($id);
            $images = $this->model('ImagesModel');
            $image = $images->getImages($id);
            $upload_dire='public/uploads/images/';
            foreach ($image as $value) {
                if (file_exists($upload_dire.$value['image'])) {
                    unlink($upload_dire.$value['image']);
                }
            }
            $images->deleteImage($id);
            $_SESSION['success'] = "Delete product successfully";
            $this->response->redirect('admin/product/list');
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function edit()
    {
        try {
            $id = $_GET['id'];
            $cats = $this->model('ProductCatModel');
            $this->data['user'] = $_SESSION['user_login']['name'];
            $this->data['cats'] = $cats->getALL();
            $this->data['product'] = $this->model->getProduct($id);
            $this->data['product_images'] = $this->model->getProductImages($id);
            $this->render('admins/product/edit', $this->data);
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function update()
    {
        try {
            $id = $_GET['id'];
            // Validate form
            $request = new Request();
            if (!$this->validateProduct($request)) {
                Session::flash('errors', $request->errors());
                Session::flash('old', $request->getFields());
                $this->response->redirect('admin/product/edit?id='.$id);
            }
            $thumb = $this->model->getProduct($id);
            if (!empty($_POST)) {
                $data = [
                    'product_name'=>$_POST['product_name'],
                    'product_des'=>$_POST['product_desc'],
                    'product_price'=>$_POST['product_price'],
                    'product_detail'=>$_POST['product_detail'],
                    'cat_id'=>$_POST['product_cat'],
                    'user_id'=>$_SESSION['user_login']['id']
                ];
                $this->db->table('tbl_products')->where('id', '=', $id)->update($data);
            }
            
            if (!empty($_FILES['product_thumb']['name'])) {
                $file_name = $_FILES['product_thumb']['name'];
                $upload_dir = 'public/uploads/products/';
                if (file_exists($upload_dir.$thumb['product_thumb'])) {
                    unlink($upload_dir.$thumb['product_thumb']);
                }
                $file_name = $this->handleFile($file_name, $upload_dir);
                move_uploaded_file($_FILES['product_thumb']['tmp_name'], $upload_dir.$file_name);
                $data=[
                    'product_thumb' => $file_name
                ];
                $this->db->table('tbl_products')->where('id', '=', $id)->update($data);
            }
            if (!empty($_FILES['product_images']['name'])) {
                $upload_dire = 'public/uploads/images/';
                $files = $_FILES['product_images']['name'];
                $image = $this->model('ImagesModel');
                $images = $image->getImages($id);
                if (!empty($images)) {
                    $image->deleteImage($id);
                    foreach ($images as $fileImage) {
                        if (file_exists($upload_dire.$fileImage['image'])) {
                            unlink($upload_dire.$fileImage['image']);
                        }
                    }
                }
                foreach ($files as $key => $fileName) {
                    $fileName = $this->handleFile($fileName, $upload_dire);
                    $upload_file = $upload_dire.$fileName;
                    move_uploaded_file($_FILES['product_images']['tmp_name'][$key], $upload_file);
                    $data = [
                        'image' => $fileName,
                        'product_id' => $id
                    ];
                    $this->db->table('tbl_product_images')->insert($data);
                }
            }
            $_SESSION['success'] = "Update product successfully";
            $this->response->redirect('admin/product/list');
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
}
