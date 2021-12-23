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
            $orders = $this->model->getAll();
            $limit = 1;
            if (count($orders)>$limit) {
                $data = $this->pagi($orders, $limit);
                if ($data['total']>0) {
                    $this->data['orders'] = $this->model->pagi_get($limit, $data['start']);
                }
                $this->data['pagination']=$data['button_pagination'];
            } else {
                $this->data['orders'] = $this->model->getAll();
            }
            $this->render('admins/order/list', $this->data);
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function show()
    {
        try {
            $id = $_GET['id'];
            $order_product = $this->model('OrderProductModel');
            $customer = $this->model('UserModel');
            $this->data['user'] = $_SESSION['user_login']['name'];
            $this->data['order'] = $this->model->find($id);
            $this->data['customer'] = $customer->find($this->data['order']['user_id']);
            $this->data['order_products'] = $order_product->getDetail($id);
            $status = array();
            if ($this->data['order']['status']=='cancel') {
                $status = array(
                        'cancel'=>'Cancel',
                        'handle'=>'Handle',
                    );
            }
            if ($this->data['order']['status']=='handle') {
                $status = array(
                        'cancel'=>'Cancel',
                        'handle'=>'Handle',
                        'transport'=>'Transport',
                    );
            }
            if ($this->data['order']['status']=='transport') {
                $status = array(
                        'transport'=>'Transport',
                        'done'=>'Done',
                    );
            }
            if ($this->data['order']['status']=='done') {
                $status = array(
                        'done'=>'Done',
                    );
            }
            $this->data['status']=$status;
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
                    'status'=>$_POST['status']
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
