<?php
class OrderController extends Controller
{
    public $model;
    public $data = array();
    public function __construct()
    {
        $response = new Response();
        if (!$this->authCustomer()) {
            $response->redirect('customer/login');
        } else {
            $this->model = $this->model('OrderModel');
        }
    }
    public function index()
    {
        $response = new Response();
        if (isset($_SESSION['customer_login'])) {
            $this->data['customer'] = $this->db->table('tbl_users')
                        ->where('id', '=', $_SESSION['customer_login']['id'])->first();
            $this->data['customer_info'] = $this->db->table('tbl_customers')
            ->where('user_id', '=', $_SESSION['customer_login']['id'])->first();
        }
        if (isset($_SESSION['cart'])) {
            $this->data['cart'] = $_SESSION['cart'];
            $this->data['errors'] = Session::flash('errors');
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
            $request = new Request();
            $request->rules([
                'phone'=>'required|regex:/^[0-9]*$/',
                'address'=>'required',
                ]);
            $request->message([
                'phone.required'=>'Please enter phone',
                'phone.regex'=>'Please enter valid phone!',
                'address.required'=>'Please enter address!',
                ]);
            $validate = $request->validate();
            if (!$validate) {
                Session::flash('errors', $request->errors());
                $response->redirect('checkout');
            }
            //Update
            $phone = [
                'phone'=>$_POST['phone'],
            ];
            $this->model('UserModel')->updateCustomer($phone);
            $address = [
                'address'=>$_POST['address'],
            ];
            $this->db->table('tbl_customers')->where('user_id', '=', $_SESSION['customer_login']['id'])->update($address);
            //
            $code = 'AP-'.time();
            $data = [
                'code'=>$code,
                'user_id'=> $_SESSION['customer_login']['id'],
                'status'=> 'handle',
                'payment'=> $_POST['payment'],
                'total_price'=> $_SESSION['cart']['info']['total'],
            ];
            if (!empty($_POST['address1'])) {
                $data['address'] = $_POST['address1'];
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
                    $response->redirect('order/done');
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
    public function done()
    {
        if (isset($_SESSION['customer_login'])) {
            $this->data['customer'] = $_SESSION['customer_login'];
        }
        $this->data['product_cats'] = $this->model('ProductCatModel')->getAll();
        $this->render('clients/order/done', $this->data);
    }
}
