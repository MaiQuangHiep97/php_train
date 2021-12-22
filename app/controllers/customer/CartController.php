<?php
class CartController extends Controller
{
    public $model;
    public $data = array();
    public function __construct()
    {
        if (!$this->authCustomer()) {
            $response = new Response();
            $response->redirect('customer/login');
        }
    }
    public function index()
    {
        if (isset($_SESSION['customer_login'])) {
            $this->data['customer'] = $_SESSION['customer_login'];
        }
        $this->data['cart'] = $_SESSION['cart'];
        $this->render('clients/cart/show', $this->data);
    }
    public function add()
    {
        //add
        $id = $_POST['product_id'];
        $qty = $_POST['product_qty'];
        if (isset($_SESSION['cart'])&&array_key_exists($id, $_SESSION['cart']['buy'])) {
            $qty = $_SESSION['cart']['buy'][$id]['qty'] + $_POST['product_qty'];
        }
        $_SESSION['cart']['buy'][$id] = array(
                'product_id' => $_POST['product_id'],
                'product_name' => $_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_thumb' => $_POST['product_thumb'],
                'qty' => $qty,
                'sub_total'=> $_POST['product_price']*$qty
                                
            );

        //info
        $num_order = 0;
        $total = 0;
        foreach ($_SESSION['cart']['buy'] as $item) {
            $num_order += $item['qty'];
            $total += $item['sub_total'];
        }
        $_SESSION['cart']['info'] = array(
            'num_order'=> $num_order,
            'total'=> $total
        );
        $response = new Response();
        $response->redirect('cart/show');
    }
}
