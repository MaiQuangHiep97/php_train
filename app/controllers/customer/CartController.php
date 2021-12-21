<?php
class CartController extends Controller
{
    public $model;
    public $data = array();
    public function index()
    {
    }
    public function add()
    {
        $id = $_POST['product_id'];
        if (isset($_SESSION['cart'])&&array_key_exists($id, $_SESSION['cart']['buy'])) {
            $qty = $_SESSION['cart']['buy'][$id]['qty'] + $_POST['product_qty'];
            $_SESSION['cart']['buy'][$id] = array(
                'product_id' => $_POST['product_id'],
                'product_name' => $_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_thumb' => $_POST['product_thumb'],
                'qty' => $qty,
                'sub_total'=> $_POST['product_price']*$qty
                                
            );
        } else {
            $_SESSION['cart']['buy'][$id] = array(
                'product_id' => $_POST['product_id'],
                'product_name' => $_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_thumb' => $_POST['product_thumb'],
                'qty' => $_POST['product_qty'],
                'sub_total'=> $_POST['product_price']*$_POST['product_qty']
                                
            );
        }
        echo '<pre>';
        print_r($_SESSION['cart']['buy']);
        //session_destroy();
    }
}
