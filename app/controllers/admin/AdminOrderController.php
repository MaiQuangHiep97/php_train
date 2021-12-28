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
            $this->data['user'] = $_SESSION['user_login']['name'];
            $this->data['orders'] = $this->model->getAll();
            $limit = 10;
            if (count($this->data['orders']) > $limit) {
                $data = Paginator::pagi($this->data['orders'], $limit);
                if ($data['total']>0) {
                    $this->data['orders'] = $this->model->pagi_get($limit, $data['start']);
                }
                $this->data['pagination'] = $data['button_pagination'];
            }
            $this->render('admins/order/list', $this->data);
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function handleStatus($statusNow)
    {
        $status = array();
        if ($statusNow == 'cancel') {
            $status = [
                'cancel' => 'Cancel',
                'handle' => 'Handle',
            ];
        }
        if ($statusNow == 'handle') {
            $status = [
                'cancel' => 'Cancel',
                'handle' => 'Handle',
                'transport' => 'Transport',
            ];
        }
        if ($statusNow == 'transport') {
            $status = [
                'transport' => 'Transport',
                'done' => 'Done',
            ];
        }
        if ($statusNow == 'done') {
            $status = [
                'done' => 'Done',
            ];
        }
        return $status;
    }
    public function getData($id)
    {
        $order_product = $this->model('OrderProductModel');
        $this->data['user'] = $_SESSION['user_login']['name'];
        $this->data['order'] = $this->model->find($id);
        $this->data['customer'] = $order_product->getCustomer($this->data['order']['user_id']);
        $this->data['order_products'] = $order_product->getDetail($id);
        return $this->data;
    }
    public function show()
    {
        try {
            $id = $_GET['id'];
            $this->data = $this->getData($id);
            $this->data['status'] = $this->handleStatus($this->data['order']['status']);
            $this->render('admins/order/show', $this->data);
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function status()
    {
        try {
            if (!empty($_POST['status'])) {
                $data = [
                    'status' => $_POST['status']
                ];
                $this->model->updateStatus($_POST['id'], $data);
                $_SESSION['success'] = "Update successfully";
                
                $response = new Response();
                $response->redirect('admin/order/detail?id='.$_POST['id']);
            }
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
}
