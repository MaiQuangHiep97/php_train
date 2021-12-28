<?php
class CartController extends Controller
{
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
        if (isset($_SESSION['cart'])) {
            $this->data['cart'] = $_SESSION['cart'];
            $this->render('clients/cart/show', $this->data);
        } else {
            $this->render('clients/cart/show');
        }
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
    public function update()
    {
        if ($_POST['numOrder'] == 0) {
            unset($_SESSION['cart']['buy'][$_POST['id']]);
            $total = 0;
            $num_order = 0;
            if (count($_SESSION['cart']['buy'])>0) {
                foreach ($_SESSION['cart']['buy'] as $item) {
                    $total += $item['sub_total'];
                    $num_order += $item['qty'];
                }
                $_SESSION['cart']['info'] = array(
                'total'=> $total,
                'num_order'=> $num_order
                );
                $data = array(
                    'numOrder'=> $_POST['numOrder'],
                    'num_order'=> $num_order,
                    'total'=>number_format($_SESSION['cart']['info']['total']).'đ'
                );
                echo json_encode($data);
            } else {
                unset($_SESSION['cart']);
                $data = [
                    'num_order'=>0,
                    'display'=>'<div class="text-center" style="margin-top: 30px;">
                                <h4 class="">There are no items in the cart </h4>
                                <a href="/demo">Home page</a>
                                </div>'
                ];
                echo json_encode($data);
            }
        } else {
            $sub_total = $_SESSION['cart']['buy'][$_POST['id']]['product_price']*$_POST['numOrder'];
            $_SESSION['cart']['buy'][$_POST['id']]['sub_total'] = $sub_total;
            $_SESSION['cart']['buy'][$_POST['id']]['qty'] = $_POST['numOrder'];
            $total = 0;
            $num_order = 0;
            foreach ($_SESSION['cart']['buy'] as $item) {
                $total += $item['sub_total'];
                $num_order += $item['qty'];
            }
            $_SESSION['cart']['info'] = array(
            'total'=> $total,
            'num_order'=> $num_order
        );
            $data = array(
            'num_order'=> $num_order,
            'sub_total'=> number_format($sub_total).'đ',
            'total'=>number_format($_SESSION['cart']['info']['total']).'đ'
        );
            echo json_encode($data);
        }
        //session_destroy();
    }
    public function delete()
    {
        $id = $_POST['id'];
        if (!empty($id)) {
            unset($_SESSION['cart']['buy'][$id]);
            $total = 0;
            $num_order = 0;
            foreach ($_SESSION['cart']['buy'] as $item) {
                $total += $item['sub_total'];
                $num_order += $item['qty'];
            }
            $_SESSION['cart']['info'] = array(
            'total'=> $total,
            'num_order'=> $num_order
        );
            $data = array(
            'id'=>$id,
            'num_order'=> $num_order,
            'total'=>number_format($_SESSION['cart']['info']['total']).'đ',
            'display'=>'<div class="text-center" style="margin-top: 30px;">
                                <h4 class="">There are no items in the cart </h4>
                                <a href="/demo">Home page</a>
                                </div>'
        );
            echo json_encode($data);
        }
    }
    public function destroy()
    {
        $response = new Response();
        if (isset($_SESSION['cart'])) {
            unset($_SESSION['cart']);
            $response->redirect('cart/show');
        }
        $response->redirect('');
    }
}
