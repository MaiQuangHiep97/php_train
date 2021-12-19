<?php
class AdminOrderController extends Controller
{
    public $model;
    public $data = array();
    public function __construct()
    {
        if (!$this->auth()) {
            $response = new Response();
            $response->redirect('admin/authcontroller/');
        }
        $this->model = $this->model('OrderModel');
    }
    public function index()
    {
        try {
            $order = $this->model('OrderModel');
            $this->data['user'] = $_SESSION['user_login']['name'];
            $orders = $order->getAll();
            $limit = 1;
            if (!empty($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $total_rows = count($orders);
            $total_page = ceil($total_rows/$limit);
            $start = ($page-1)*$limit;
            if ($total_rows>0) {
                $this->data['orders'] = $order->pagi_get($limit, $start);
            }
            $button_pagination = $this->pagination($total_page, $page);
            $this->data['pagination']=$button_pagination;
            $this->render('admins/order/list', $this->data);
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function show()
    {
        try {
            $order = $this->model('OrderModel');
            $this->data['user'] = $_SESSION['user_login']['name'];
            $this->render('admins/order/show', $this->data);
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
}
