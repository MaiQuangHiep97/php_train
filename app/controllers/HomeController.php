<?php
class HomeController extends Controller
{
    public $model;
    public $data = array();
    public function __construct()
    {
        $this->model = $this->model('ProductModel');
    }
    public function index()
    {
        if (isset($_SESSION['customer_login'])) {
            $this->data['customer'] = $_SESSION['customer_login'];
        }
        $products = $this->model('ProductModel')->getProducts();
        $limit = 4;
        $data = $this->pagi($products, $limit);
        if ($data['total']>0) {
            $this->data['products'] = $this->model->getPagi($limit, $data['start']);
        }
        $this->data['pagination']=$data['button_pagination'];
        $this->data['product_cats'] = $this->model('ProductCatModel')->getAll();
        $this->render('clients/home/index', $this->data);
    }
    public function getProduct($cat_id)
    {
        if (isset($_SESSION['customer_login'])) {
            $this->data['customer'] = $_SESSION['customer_login'];
        }
        $products = $this->db->table('tbl_products')->where('cat_id', '=', $cat_id)->get();
        $limit = 2;
        $data = $this->pagi($products, $limit);
        if ($data['total']>0) {
            $this->data['products'] = $this->db->table('tbl_products')
            ->where('cat_id', '=', $cat_id)->limit($limit, $data['start'])->get();
        }
        $this->data['pagination']=$data['button_pagination'];
        $this->data['product_cats'] = $this->model('ProductCatModel')->getAll();
        $this->data['cat_id'] = $cat_id;
        $this->render('clients/home/cat', $this->data);
    }
}
