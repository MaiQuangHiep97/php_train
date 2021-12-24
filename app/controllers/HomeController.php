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
        $this->data['products'] = $this->model('ProductModel')->getProducts();
        $limit = 8;
        if (count($this->data['products'])>$limit) {
            $data = $this->pagi($this->data['products'], $limit);
            if ($data['total']>0) {
                $this->data['products'] = $this->model->getPagi($limit, $data['start']);
            }
            $this->data['pagination']=$data['button_pagination'];
        }
        $this->data['product_cats'] = $this->model('ProductCatModel')->getAll();
        $this->render('clients/home/index', $this->data);
    }
    public function getProduct($cat_id)
    {
        if (isset($_SESSION['customer_login'])) {
            $this->data['customer'] = $_SESSION['customer_login'];
        }
        $this->data['products'] = $this->db->table('tbl_products')->where('cat_id', '=', $cat_id)->get();
        $limit = 4;
        if (count($this->data['products'])>$limit) {
            $data = $this->pagi($this->data['products'], $limit);
            if ($data['total']>0) {
                $this->data['products'] = $this->db->table('tbl_products')
            ->where('cat_id', '=', $cat_id)->limit($limit, $data['start'])->get();
            }
            $this->data['pagination']=$data['button_pagination'];
        }
        $this->data['product_cats'] = $this->model('ProductCatModel')->getAll();
        $this->data['cat_id'] = $cat_id;
        $this->render('clients/home/cat', $this->data);
    }
    public function search()
    {
        if (isset($_SESSION['customer_login'])) {
            $this->data['customer'] = $_SESSION['customer_login'];
        }
        $this->data['product_cats'] = $this->model('ProductCatModel')->getAll();
        if (!empty($_POST['search'])) {
            $this->data['key'] = $_POST['search'];
            $this->data['products'] = $this->model->getSearch($this->data['key']);
        }
        $this->render('clients/home/search', $this->data);
    }
}
