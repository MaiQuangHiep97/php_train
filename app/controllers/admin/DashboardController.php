<?php
class DashboardController extends Controller
{
    public $model;
    public function __construct()
    {
        if (!$this->auth()) {
            $response = new Response();
            $response->redirect('admin/login');
        }
        $this->model = $this->model('OrderModel');
    }
    public function index()
    {
        try {
            $this->data['user'] = $_SESSION['user_login']['name'];
            $orders = $this->model->getAll();
            $limit = 1;
            if (!empty($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
            $total_rows = count($orders);
            $total_page = ceil($total_rows/$limit);
            $start = ($page-1)*$limit;
            if ($total_rows>0) {
                $this->data['orders'] = $this->model->pagi_get($limit, $start);
            }
            $button_pagination = $this->pagination($total_page, $page);
            $this->data['pagination']=$button_pagination;
            $this->data['cancel']=$this->model->countCancel();
            $this->data['handle']=$this->model->countHandle();
            $this->data['transport']=$this->model->countTransport();
            $this->data['done']=$this->model->countDone();
            $total=$this->db->table('tbl_orders')->where('status', '=', 'done')->select('total_price')->get();
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
}
