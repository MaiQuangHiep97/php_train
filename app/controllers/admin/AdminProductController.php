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
        $this->render('admins/product/list', $this->data);
    }
    public function add()
    {
        $cats = $this->model('ProductCatModel');
        $this->data['cats'] = $cats->getALL();
        $this->data['user'] = $_SESSION['user_login']['name'];
        $this->render('admins/product/add', $this->data);
    }


    // Hàm này em sẽ tối ưu sau

    public function store()
    {
        try {
            if (isset($_POST) && isset($_FILES)) {
                $file_name = $_FILES['product_thumb']['name'];
                $upload_dir = 'public/uploads/';
                $type = pathinfo($file_name, PATHINFO_EXTENSION);
                $upload_file = $upload_dir.$file_name;
                if (file_exists($upload_file)) {
                    $file_name = pathinfo($_FILES['product_thumb']['name'], PATHINFO_FILENAME);
                    $new_file_name = $file_name.'-Copy.';
                    $new_upload_file = $upload_dir.$new_file_name.$type;
                    $k = 1;
                    while (file_exists($new_upload_file)) {
                        $new_file_name = $file_name."-Copy({$k}).";
                        $k++;
                        $new_upload_file = $upload_dir.$new_file_name.$type;
                    }
                    $file_name = $new_file_name.$type;
                    $upload_file = $new_upload_file;
                }
                move_uploaded_file($_FILES['product_thumb']['tmp_name'], $upload_file);
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
                if (isset($id)) {
                    $files = $_FILES['product_images'];
                    $filenames = $files['name'];
                    foreach ($filenames as $key => $value) {
                        //
                        $file_name = $value;
                        //$upload_dir = 'public/uploads/';
                        $type = pathinfo($file_name, PATHINFO_EXTENSION);
                        $upload_file = $upload_dir.$file_name;
                        if (file_exists($upload_file)) {
                            $file_name = pathinfo($file_name, PATHINFO_FILENAME);
                            $new_file_name = $file_name.'-Copy.';
                            $new_upload_file = $upload_dir.$new_file_name.$type;
                            $k = 1;
                            while (file_exists($new_upload_file)) {
                                $new_file_name = $file_name."-Copy({$k}).";
                                $k++;
                                $new_upload_file = $upload_dir.$new_file_name.$type;
                            }
                            $file_name = $new_file_name.$type;
                            $upload_file = $new_upload_file;
                        }
                        move_uploaded_file($files['tmp_name'][$key], $upload_file);
                        $image = [
                            'image'=>$file_name,
                            'product_id'=>$id
                        ];
                        $this->db->table('tbl_product_images')->insert($image);
                    }
                }
                echo "Insert success";
            }
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
}
