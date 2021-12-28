<?php
class AdminOrderController extends Controller
{
    public $response;
    public $data = array();
    public $repoOrder;
    public $repoCustomer;
    public $repoOrderProduct;
    public function __construct()
    {
        $this->response = new Response();
        if (!$this->auth()) {
            $this->response->redirect('admin/login/');
        }
        $this->repoOrder = new OrderRepository();
        $this->repoOrderProduct = new OrderProductRepository();
        $this->repoCustomer = new CustomerRepository();
    }
    public function index()
    {
        try {
            $this->data['user'] = $_SESSION['user_login']['name'];
            $this->data['orders'] = $this->repoOrder->getOrder();
            $limit = 10;
            if (count($this->data['orders']) > $limit) {
                $data = Paginator::pagi($this->data['orders'], $limit);
                if ($data['total']>0) {
                    $this->data['orders'] = $this->repoOrder->pagiGetOrder($limit, $data['start']);
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
        $this->data['user'] = $_SESSION['user_login']['name'];
        $this->data['order'] = $this->repoOrder->find($id);
        $this->data['customer'] = $this->repoCustomer->getCustomer($this->data['order']['user_id']);
        $this->data['order_products'] = $this->repoOrderProduct->getDetail($id);
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
                $this->repoOrder->update($_POST['id'], $data);
                $_SESSION['success'] = "Update successfully";
                $this->response->redirect('admin/order/detail?id='.$_POST['id']);
            }
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
}
