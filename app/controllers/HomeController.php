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
        $this->data['categorys'] = $this->handleCate();
        $this->render('clients/home/index', $this->data);
    }
    public function getProduct($category)
    {
        $string = str_replace('-', ' ', $category);
        $key = ucwords($string);
        $cate = $this->repoCate->getCat($key);
        if (isset($_SESSION['customer_login'])) {
            $this->data['customer'] = $_SESSION['customer_login'];
        }
        $this->data['products'] = $this->repoProduct->getWithCat($cate['id']);
        $limit = 10;
        if (count($this->data['products'])>$limit) {
            $data = Paginator::pagi($this->data['products'], $limit);
            if ($data['total']>0) {
                $this->data['products'] = $this->repoProduct->getWithCatPagi($cate['id'], $limit, $data['start']);
            }
            $this->data['pagination']=$data['button_pagination'];
        }
        $this->data['cate'] = $category;
        $this->data['categorys'] = $this->handleCate();
        $this->render('clients/home/cat', $this->data);
        $this->handleCate();
    }
    public function handleCate()
    {
        $cates = $this->repoCate->getAll();
        foreach ($cates as $cate) {
            $cate['url'] = str_replace(' ', '-', strtolower($cate['cat_name']));
            $data[] = $cate;
        }
        return $data;
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
        $this->data['categorys'] = $this->handleCate();
        $this->render('clients/home/search', $this->data);
    }
}
