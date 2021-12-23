<?php
class OrderController extends Controller
{
    public $model;
    public $data = array();
    public function __construct()
    {
        if (!$this->authCustomer()) {
            $response = new Response();
            $response->redirect('customer/login');
        } else {
            $this->model = $this->model('OrderModel');
        }
    }
    public function index()
    {
        $response = new Response();
        if (isset($_SESSION['customer_login'])) {
            $this->data['customer'] = $_SESSION['customer_login'];
            $this->data['customer_info'] = $this->db->table('tbl_customers')
            ->where('user_id', '=', $_SESSION['customer_login']['id'])->first();
        }
        if (isset($_SESSION['cart'])) {
            $this->data['cart'] = $_SESSION['cart'];
        } else {
            $response->redirect('');
        }
        $this->data['product_cats'] = $this->model('ProductCatModel')->getAll();
        $this->render('clients/order/index', $this->data);
    }
    public function postCheckout()
    {
        $response = new Response();
        if (!empty($_POST)) {
            $code = 'AP-'.time();
            $data = [
                'code'=>$code,
                'user_id'=> $_SESSION['customer_login']['id'],
                'status'=> 'handle',
                'payment'=> $_POST['payment'],
                'total_price'=> $_SESSION['cart']['info']['total'],
            ];
            if (!empty($_POST['address'])) {
                $data['address'] = $_POST['address'];
            }
            try {
                $this->model->insertOrder($data);
                $id = $this->db->lastInsertID();
                if (!empty($id)) {
                    foreach ($_SESSION['cart']['buy'] as $item) {
                        $data = array(
                                'order_id'=> $id,
                                'quantity'=> $item['qty'],
                                'product_id'=>$item['product_id']
                            );
                        $this->db->table('tbl_order_products')->insert($data);
                    }
                    unset($_SESSION['cart']);
                    echo "abc";
                } else {
                    $exception = new Exception('Order fails');
                    throw $exception;
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            $response->redirect('');
        }
    }
}
