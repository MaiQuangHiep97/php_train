<?php
class ProductController extends Controller
{
    public $repoProduct;
    public $repoCate;
    public $repoImage;
    public $data = array();
    public function __construct()
    {
        $this->repoProduct = new ProductRepository();
        $this->repoCate = new ProductCatRepository();
        $this->repoImage = new ProductImageRepository();
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
        $this->data['product_cats'] = $this->repoCate->getAll();
        $this->data['product'] = $this->repoProduct->find($id);
        $this->data['images'] = $this->repoImage->getImages($id);
        $this->data['products'] = $this->repoProduct->getLimit();
        return $this->data;
    }
}
