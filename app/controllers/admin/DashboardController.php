<?php
class DashboardController extends Controller
{
    public function __construct()
    {
        if (!$this->auth()) {
            $response = new Response();
            $response->redirect('admin/login');
        }
    }
    public function index()
    {
        $this->data['user'] = $_SESSION['user_login']['name'];
        $this->render('admins/dashboard/dashboard', $this->data);
    }
}
