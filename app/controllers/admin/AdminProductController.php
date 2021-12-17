<?php
class AdminProductController extends Controller
{
    public $model;
    public $data = array();
    public function __construct()
    {
        if (!$this->auth()) {
            $response = new Response();
            $response->redirect('admin/authcontroller/');
        }
        $this->model = $this->model('ProductModel');
    }
    public function index()
    {
        $this->data['user'] = $_SESSION['user_login']['name'];
        $products = $this->model('ProductModel');
        $this->data['products'] = $products->getAll();
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

    public function store()
    {
        try {
            $response = new Response();
            // Validate form
            $request = new Request();
            if ($request->isPost()) {
                $request->rules([
                    'product_name'=>'required',
                    'product_desc'=>'required',
                    'product_detail'=>'required',
                    'product_price'=>'required|regex:/^[0-9]*$/',
                    'product_cat'=>'required',
                ]);
                $request->message([
                    'product_name.required'=>'Please enter product name',
                    'product_desc.required'=>'Please enter description',
                    'product_detail.required'=>'Please enter detail',
                    'product_price.required'=>'Please enter price',
                    'product_price.regex'=>'Please enter valid price!',
                    'product_cat.required'=>'Please select category',
                ]);
                $validate = $request->validate();
                if (!$validate) {
                    Session::flash('errors', $request->errors());
                    Session::flash('old', $request->getFields());
                    $response->redirect('admin/adminproductcontroller/add');
                }
            } else {
                $response->redirect('admin/adminproductcontroller/add');
            }
            if (!empty($_POST) && !empty($_FILES)) {
                $file_name = $_FILES['product_thumb']['name'];
                $type = pathinfo($file_name, PATHINFO_EXTENSION);
                $type_allow = array('png','jpg','jpeg','gift');
                if (!in_array(strtolower($type), $type_allow)) {
                    $response->redirect('admin/adminproductcontroller/add');
                } else {
                    $upload_dir = 'public/uploads/products/';
                    $file_name = $this->handleFile($file_name, $upload_dir);
                    
                    move_uploaded_file($_FILES['product_thumb']['tmp_name'], $upload_dir.$file_name);
                    $data = [
                    'product_name'=>$_POST['product_name'],
                    'product_des'=>$_POST['product_desc'],
                    'product_price'=>$_POST['product_price'],
                    'product_detail'=>$_POST['product_detail'],
                    'product_thumb'=>$file_name,
                    'cat_id'=>$_POST['product_cat'],
                    'user_id'=>$_SESSION['user_login']['id']
                ];
                    $product = $this->model('ProductModel');
                    $product->insertProduct($data);
                    $id = $this->db->lastInsertID();
                }
                if (isset($id)) {
                    $files = $_FILES['product_images'];
                    $filenames = $files['name'];
                    $upload_dir = 'public/uploads/images/';
                    foreach ($filenames as $key => $value) {
                        //
                        $file_name = $value;
                        $type = pathinfo($file_name, PATHINFO_EXTENSION);
                        $file_name = $this->handleFile($file_name, $upload_dir);
                        $upload_file = $upload_dir.$file_name;
                        move_uploaded_file($files['tmp_name'][$key], $upload_file);
                        $image = [
                            'image'=>$file_name,
                            'product_id'=>$id
                        ];
                        $this->db->table('tbl_product_images')->insert($image);
                    }
                }
                $_SESSION['success'] = "Add product successfully";
                $response->redirect('admin/adminproductcontroller/');
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
            $products = $this->model('ProductModel');
            $product = $products->getProduct($id);
            $upload_dir='public/uploads/products/';
            if (file_exists($upload_dir.$product['product_thumb'])) {
                unlink($upload_dir.$product['product_thumb']);
            }
            $products->deleteProduct($id);
            $images = $this->model('ImagesModel');
            $image = $images->getImages($id);
            $upload_dire='public/uploads/images/';
            foreach ($image as $value) {
                if (file_exists($upload_dire.$value['image'])) {
                    unlink($upload_dire.$value['image']);
                }
            }
            $images->deleteImage($id);
            $response = new Response();
            $_SESSION['success'] = "Delete product successfully";
            $response->redirect('admin/adminproductcontroller/');
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
            $product = $this->model('ProductModel');
            $this->data['product'] = $product->getProduct($id);
            $this->data['product_images'] = $product->getProductImages($id);
            $this->render('admins/product/edit', $this->data);
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function update()
    {
        try {
            $response = new Response();
            $id = $_GET['id'];
            // Validate form
            $request = new Request();
            if ($request->isPost()) {
                $request->rules([
                    'product_name'=>'required',
                    'product_desc'=>'required',
                    'product_detail'=>'required',
                    'product_price'=>'required|regex:/^[0-9]*$/',
                    'product_cat'=>'required',
                ]);
                $request->message([
                    'product_name.required'=>'Please enter product name',
                    'product_desc.required'=>'Please enter description',
                    'product_detail.required'=>'Please enter detail',
                    'product_price.required'=>'Please enter price',
                    'product_price.regex'=>'Please enter valid price!',
                    'product_cat.required'=>'Please select category',
                ]);
                $validate = $request->validate();
                if (!$validate) {
                    Session::flash('errors', $request->errors());
                    Session::flash('old', $request->getFields());
                    $response->redirect('admin/adminproductcontroller/edit?id='.$id);
                }
            } else {
                $response->redirect('admin/adminproductcontroller/edit?id='.$id);
            }
            $product = $this->model('ProductModel');
            $thumb = $product->getProduct($id);
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
                    'product_thumb'=>$file_name
                ];
                $this->db->table('tbl_products')->where('id', '=', $id)->update($data);
            }
            if (!empty($_FILES['product_images']['name'])) {
                $upload_dire = 'public/uploads/images/';
                $files = $_FILES['product_images']['name'];
                $image = $this->model('ImagesModel');
                $images= $image->getImages($id);
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
                        'image'=>$fileName,
                        'product_id'=>$id
                    ];
                    $this->db->table('tbl_product_images')->insert($data);
                }
            }
            $_SESSION['success'] = "Update product successfully";
            $response->redirect('admin/adminproductcontroller/');
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
}
