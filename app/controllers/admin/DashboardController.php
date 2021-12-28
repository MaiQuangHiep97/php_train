<?php
class DashboardController extends Controller
{
    public $model;
    public $response;
    public function __construct()
    {
        $this->response = new Response();
        if (!$this->auth()) {
            $this->response->redirect('admin/login');
        }
        $this->model = $this->model('OrderModel');
    }
    public function index()
    {
        try {
            $this->data['user'] = $_SESSION['user_login']['name'];
            $orders = $this->model->getAll();
            $limit = 10;
            if (count($orders)>$limit) {
                $data = Paginator::pagi($orders, $limit);
                if ($data['total']>0) {
                    $this->data['orders'] = $this->model->pagi_get($limit, $data['start']);
                    $this->data['pagination']=$data['button_pagination'];
                }
            } else {
                $this->data['orders'] = $this->model->getAll();
            }
            $this->data = $this->getCount();
            $total=$this->model->getTotal();
            $sum=0;
            foreach ($total as $value) {
                $sum += $value['total_price'];
            }
            $this->data['total_revenue'] = $sum;
            $this->render('admins/dashboard/dashboard', $this->data);
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            echo "Database error: $error_message";
        }
    }
    public function getCount()
    {
        $this->data['cancel'] = $this->model->countCancel();
        $this->data['handle'] = $this->model->countHandle();
        $this->data['transport'] = $this->model->countTransport();
        $this->data['done'] = $this->model->countDone();
        return $this->data;
    }
}
