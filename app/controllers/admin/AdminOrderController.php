<?php
class AdminOrderController extends Controller
{
    public $response;
    public $data = array();
    public $repoOrder;
    public $repoUser;
    public $repoCustomer;
    public $repoOrderProduct;
    public $repoProduct;
    public function __construct()
    {
        $this->response = new Response();
        if (!$this->auth()) {
            $this->response->redirect('admin-login/');
        }
        $this->repoOrder = new OrderRepository();
        $this->repoOrderProduct = new OrderProductRepository();
        $this->repoCustomer = new CustomerRepository();
        $this->repoProduct = new ProductRepository();
        $this->repoUser = new UserRepository();
    }
    public function index()
    {
        $this->data['user'] = $_SESSION['user_login']['name'];
        if (!empty($_GET['key'])) {
            $this->data = $this->search();
        } elseif (!empty($_GET['status'])) {
            $this->data = $this->fillStatus();
        } else {
            $this->data['orders'] = $this->repoOrder->getOrder();
            $limit = 20;
            if (count($this->data['orders']) > $limit) {
                $data = Paginator::pagi($this->data['orders'], $limit);
                if ($data['total']>0) {
                    $this->data['orders'] = $this->repoOrder->pagiGetOrder($limit, $data['start']);
                }
                $this->data['pagination'] = $data['button_pagination'];
            }
        }
        $this->render('admins/order/list', $this->data);
    }
    public function search()
    {
        $this->data['key'] = $_GET['key'];
        $limit = 20;
        $this->data['orders'] = $this->repoOrder->getSearch($_GET['key']);
        if (count($this->data['orders']) > $limit) {
            $data = Paginator::pagi($this->data['orders'], $limit);
            if ($data['total'] > 0) {
                $this->data['orders'] = $this->repoOrder->getSearchPagi($limit, $data['start'], $_GET['key']);
            }
            $this->data['pagination'] = $data['button_pagination'];
        }
        return $this->data;
    }
    public function fillStatus()
    {
        $this->data['status'] = $_GET['status'];
        $limit = 20;
        $this->data['orders'] = $this->repoOrder->getStatus($_GET['status']);
        if (count($this->data['orders']) > $limit) {
            $data = Paginator::pagi($this->data['orders'], $limit);
            if ($data['total'] > 0) {
                $this->data['orders'] = $this->repoOrder->getStatusPagi($limit, $data['start'], $_GET['status']);
            }
            $this->data['pagination'] = $data['button_pagination'];
        }
        return $this->data;
    }
    public function validateInfo($request)
    {
        $request->rules([
            'phone' => 'required|regex:/^[0-9]*$/',
            'address' => 'required',
        ]);
        $request->message([
            'phone.required' => 'Please enter phone',
            'phone.regex' => 'Please enter valid phone',
            'address.required' => 'Please enter password',
        ]);
        $validate = $request->validate();
        return $validate;
    }
    public function updateInfo()
    {
        $request = new Request();
        if (!$this->validateInfo($request)) {
            Session::flash('errors', $request->errors());
            $this->response->redirect('admin-order-edit-'.$_POST['order_id'].'.html');
        }
        if (!empty($_POST['phone'])) {
            $data = [
                'phone' => $_POST['phone']
            ];
            $this->repoUser->update($_POST['id'], $data);
        }
        if (!empty($_POST['address'])) {
            $data = [
                'address' => $_POST['address']
            ];
            $this->repoOrder->update($_POST['order_id'], $data);
        }
        $_SESSION['success'] = "Update successfully";
        $this->response->redirect('admin-order-edit-'.$_POST['order_id'].'.html');
    }
    public function addProduct($id)
    {
        if (!empty($id)) {
            $this->data['order_id'] = $id;
        }
        $this->data['user'] = $_SESSION['user_login']['name'];
        $this->data['products'] = $this->repoProduct->getProduct();
        $this->render('admins/order/addProduct', $this->data);
    }
    public function updateTotal($order_id)
    {
        $data = $this->db->table('tbl_order_products')->where('order_id', '=', $order_id)
            ->join('tbl_products', 'tbl_products.id=tbl_order_products.product_id')->select('quantity, product_price')->get();
        $total = 0;
        foreach ($data as $value) {
            $total += $value['quantity']*$value['product_price'];
        }
        return $total;
    }
    public function storeProduct()
    {
        if (!empty($_POST)) {
            $data = $this->repoOrderProduct->getWithOrder($_POST['id']);
            $id_arr = [];
            foreach ($data as $value) {
                $id_arr[] = $value['product_id'];
            }
            if (in_array($_POST['product_id'], $id_arr)) {
                $qty_arr = $this->repoOrderProduct->getQty($_POST['id'], $_POST['product_id']);
                $qty = $qty_arr['quantity'] + $_POST['product_qty'];
                $data = [
                    'quantity' => $qty
                ];
                $this->repoOrderProduct->updateQty($_POST['id'], $_POST['product_id'], $data);
            } else {
                $data = [
                    'order_id' => $_POST['id'],
                    'quantity' => $_POST['product_qty'],
                    'product_id' => $_POST['product_id']
                  ];
                $this->repoOrderProduct->insert($data);
            }
            $total = $this->updateTotal($_POST['id']);
            $data = [
                'total_price' => $total
            ];
            $this->repoOrder->update($_POST['id'], $data);
            $data = [
                'data' => 'Add to Order success'
            ];
            echo json_encode($data);
        }
    }
    public function edit($id)
    {
        $this->data['errors'] = Session::flash('errors');
        $this->data = $this->getData($id);
        $this->render('admins/order/edit', $this->data);
    }
    public function updateQty()
    {
        if (!empty($_POST)) {
            $data = [
                'quantity' => $_POST['numOrder']
            ];
            $this->repoOrderProduct->updateQty($_POST['idOrder'], $_POST['id'], $data);
            $sub_total = $_POST['price']*$_POST['numOrder'];
            $total = $this->updateTotal($_POST['idOrder']);
            $data = [
                'total_price' => $total
            ];
            $this->repoOrder->update($_POST['idOrder'], $data);
            $this->db->table('tbl_order_products')->where('quantity', '=', 0)->delete();
            $data = [
                'numOrder' => $_POST['numOrder'],
                'total' => number_format($total).'đ',
                'sub_total' => number_format($sub_total).'đ'
            ];
            echo json_encode($data);
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
        $this->data['user'] = $_SESSION['user_login']['name'];
        $this->data['order'] = $this->repoOrder->find($id);
        $this->data['customer'] = $this->repoCustomer->getCustomer($this->data['order']['user_id']);
        $this->data['order_products'] = $this->repoOrderProduct->getDetail($id);
        return $this->data;
    }
    public function show($id)
    {
        try {
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
                $this->repoOrder->update($_POST['id'], $data);
                $_SESSION['success'] = "Update successfully";
                $this->response->redirect('admin-order-detail-'.$_POST['id'].'.html');
            }
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
}
