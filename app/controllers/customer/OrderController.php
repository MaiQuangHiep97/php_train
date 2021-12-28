<?php
class OrderController extends Controller
{
    public $repoOrder;
    public $repoCate;
    public $repoUser;
    public $repoCustomer;
    public $repoOrderProduct;
    public $data = array();
    public $response;
    public function __construct()
    {
        $this->response = new Response();
        if (!$this->authCustomer()) {
            $this->response->redirect('customer/login');
        }
        $this->repoOrder = new OrderRepository();
        $this->repoCate = new ProductCatRepository();
        $this->repoUser = new UserRepository();
        $this->repoCustomer = new CustomerRepository();
        $this->repoOrderProduct = new OrderProductRepository();
    }
    public function index()
    {
        if (isset($_SESSION['customer_login'])) {
            $id = $_SESSION['customer_login']['id'];
            $this->data['customer'] = $this->repoUser->find($id);
            $this->data['customer_info'] = $this->repoCustomer->find($id);
        }
        if (isset($_SESSION['cart'])) {
            $this->data['cart'] = $_SESSION['cart'];
            $this->data['errors'] = Session::flash('errors');
        } else {
            $this->response->redirect('');
        }
        $this->data['product_cats'] = $this->repoCate->getAll();
        $this->render('clients/order/index', $this->data);
    }
    public function validateCheckout($request)
    {
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
        return $validate;
    }
    public function postCheckout()
    {
        if (!empty($_POST)) {
            $request = new Request();
            if (!$this->validateCheckout($request)) {
                Session::flash('errors', $request->errors());
                $this->response->redirect('checkout');
            }
            //Update
            $phone = [
                'phone'=>$_POST['phone'],
            ];
            $id = $_SESSION['customer_login']['id'];
            $this->repoUser->update($id, $phone);
            $address = [
                'address'=>$_POST['address'],
            ];
            $this->repoCustomer->updateWithUserId($id, $address);
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
                $this->repoOrder->insert($data);
                $id = $this->db->lastInsertID();
                if (!empty($id)) {
                    foreach ($_SESSION['cart']['buy'] as $item) {
                        $data = array(
                                'order_id'=> $id,
                                'quantity'=> $item['qty'],
                                'product_id'=>$item['product_id']
                            );
                        $this->repoOrderProduct->insert($data);
                    }
                    unset($_SESSION['cart']);
                    $this->response->redirect('order/done');
                } else {
                    $exception = new Exception('Order fails');
                    throw $exception;
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            $this->response->redirect('');
        }
    }
    public function done()
    {
        if (isset($_SESSION['customer_login'])) {
            $this->data['customer'] = $_SESSION['customer_login'];
        }
        $this->data['product_cats'] = $this->repoCate->getAll();
        $this->render('clients/order/done', $this->data);
    }
}
