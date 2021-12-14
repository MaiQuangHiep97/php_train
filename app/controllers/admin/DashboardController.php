<?php
class DashboardController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['is_login'])&&!isset($_SESSION['user_login'])) {
            $response = new Response();
            $response->redirect('admin/authcontroller/');
        }
    }
    public function index()
    {
        $this->data['user'] = $_SESSION['user_login']['name'];
        $this->render('admins/dashboard/dashboard', $this->data);
    }
}
