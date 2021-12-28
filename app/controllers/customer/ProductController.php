<?php
class ProductController extends Controller
{
    public $model;
    public $data = array();
    public function __construct()
    {
        $this->model = $this->model('ProductModel');
    }
    public function index()
    {
        $this->data = $this->getData();
        $this->render('clients/product/index', $this->data);
    }
    public function getData()
    {
        if (isset($_SESSION['customer_login'])) {
            $this->data['customer'] = $_SESSION['customer_login'];
        }
        $id = $_GET['id'];
        $this->data['product_cats'] = $this->model('ProductCatModel')->getAll();
        $this->data['product'] = $this->model->find($id);
        $images = $this->model('ImagesModel');
        $this->data['images'] = $images->getImages($id);
        $this->data['products'] = $this->db->table('tbl_products')->limit(4)->get();
        return $this->data;
    }
}
