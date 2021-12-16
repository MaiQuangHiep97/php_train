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
        $this->data['products'] = $this->db->table('tbl_products')
        ->join('tbl_product_cats', 'tbl_product_cats.id=tbl_products.cat_id')
        ->select('tbl_products.id as id_pr, tbl_product_cats.id as id_cat, product_name, product_detail, product_thumb, product_price, cat_name')->get();
        $this->render('admins/product/list', $this->data);
    }
    public function add()
    {
        $cats = $this->model('ProductCatModel');
        $this->data['cats'] = $cats->getALL();
        $this->data['user'] = $_SESSION['user_login']['name'];
        $this->render('admins/product/add', $this->data);
    }

    public function store()
    {
        try {
            $response = new Response();
            if (isset($_POST) && isset($_FILES)) {
                $file_name = $_FILES['product_thumb']['name'];
                $type = pathinfo($file_name, PATHINFO_EXTENSION);
                $type_allow = array('png','jpg','jpeg','gift');
                if (!in_array(strtolower($type), $type_allow)) {
                    $response->redirect('admin/adminproductcontroller/add');
                } else {
                    $upload_dir = 'public/uploads/';
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
            $id = $_POST['id'];
            $product = $this->model('ProductModel');
            $image = $product->getProduct($id);
            $upload_dir = 'public/uploads/';
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
            
            if (!empty($_FILES['product_thumb'])) {
                $file_name = $_FILES['product_thumb']['name'];
                $type = pathinfo($file_name, PATHINFO_EXTENSION);
                $type_allow = array('png','jpg','jpeg','gift');
                if (!in_array(strtolower($type), $type_allow)) {
                    $_SESSION['erorr'] = "The file is not in the correct format";
                    $response->redirect('admin/adminproductcontroller/edit');
                }
                $upload_dir = 'public/uploads/';
                if (file_exists($upload_dir.$image['product_thumb'])) {
                    unlink($upload_dir.$image['product_thumb']);
                }
                $file_name = $this->handleFile($file_name, $upload_dir);
                move_uploaded_file($_FILES['product_thumb']['tmp_name'], $upload_dir.$file_name);
                $data=[
                    'product_thumb'=>$file_name
                ];
                $this->db->table('tbl_products')->where('id', '=', $id)->update($data);
            }
            if (!empty($_FILES['product_images'])) {
                $files = $_FILES['product_images']['name'];
                $images= $product->getProductImages($id);
                $this->db->table('tbl_product_images')->where('product_id', '=', $id)->delete();
                foreach ($images as $value) {
                    if (file_exists($upload_dir.$value['image'])) {
                        unlink($upload_dir.$value['image']);
                    }
                }
                foreach ($files as $key => $file_name) {
                    $file_name = $this->handleFile($file_name, $upload_dir);
                    $upload_file = $upload_dir.$file_name;
                    move_uploaded_file($_FILES['product_images']['tmp_name'][$key], $upload_file);
                    $image = [
                        'image'=>$file_name,
                        'product_id'=>$id
                    ];
                    $this->db->table('tbl_product_images')->insert($image);
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
