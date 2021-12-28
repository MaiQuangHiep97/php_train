<?php
class DashboardController extends Controller
{
    public $repoOrder;
    public $response;
    public function __construct()
    {
        $this->response = new Response();
        if (!$this->auth()) {
            $this->response->redirect('admin/login');
        }
        $this->repoOrder = new OrderRepository();
    }
    public function index()
    {
        try {
            $this->data['user'] = $_SESSION['user_login']['name'];
            $this->data['orders'] = $this->repoOrder->getOrder();
            $limit = 10;
            if (count($this->data['orders'])>$limit) {
                $data = Paginator::pagi($this->data['orders'], $limit);
                if ($data['total']>0) {
                    $this->data['orders'] = $this->repoOrder->pagiGetOrder($limit, $data['start']);
                    $this->data['pagination']=$data['button_pagination'];
                }
            }
            $this->data = $this->getCount();
            $total=$this->repoOrder->getTotal();
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
        $this->data['cancel'] = $this->repoOrder->countCancel();
        $this->data['handle'] = $this->repoOrder->countHandle();
        $this->data['transport'] = $this->repoOrder->countTransport();
        $this->data['done'] = $this->repoOrder->countDone();
        return $this->data;
    }
}
