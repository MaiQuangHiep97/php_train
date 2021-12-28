<?php
class HomeController extends Controller
{
    public $repoProduct;
    public $repoCate;
    public $data = array();
    public function __construct()
    {
        $this->repoProduct = new ProductRepository();
        $this->repoCate = new ProductCatRepository();
    }
    public function index()
    {
        if (isset($_SESSION['customer_login'])) {
            $this->data['customer'] = $_SESSION['customer_login'];
        }
        $this->data['products'] = $this->repoProduct->getAll();
        $limit = 4;
        if (count($this->data['products'])>$limit) {
            $data = Paginator::pagi($this->data['products'], $limit);
            if ($data['total']>0) {
                $this->data['products'] = $this->repoProduct->getPagi($limit, $data['start']);
            }
            $this->data['pagination']=$data['button_pagination'];
        }
        $this->data['product_cats'] = $this->repoCate->getAll();
        $this->render('clients/home/index', $this->data);
    }
    public function getProduct($cat_id)
    {
        if (isset($_SESSION['customer_login'])) {
            $this->data['customer'] = $_SESSION['customer_login'];
        }
        $this->data['products'] = $this->repoProduct->getWithCat($cat_id);
        $limit = 10;
        if (count($this->data['products'])>$limit) {
            $data = Paginator::pagi($this->data['products'], $limit);
            if ($data['total']>0) {
                $this->data['products'] = $this->repoProduct->getWithCatPagi($cat_id, $limit, $data['start']);
            }
            $this->data['pagination']=$data['button_pagination'];
        }
        $this->data['product_cats'] = $this->repoCate->getAll();
        $this->data['cat_id'] = $cat_id;
        $this->render('clients/home/cat', $this->data);
    }
    public function search()
    {
        if (isset($_SESSION['customer_login'])) {
            $this->data['customer'] = $_SESSION['customer_login'];
        }
        $this->data['product_cats'] = $this->repoCate->getAll();
        if (!empty($_POST['search'])) {
            $this->data['key'] = $_POST['search'];
            $this->data['products'] = $this->repoProduct->getSearch($this->data['key']);
        }
        $this->render('clients/home/search', $this->data);
    }
}
