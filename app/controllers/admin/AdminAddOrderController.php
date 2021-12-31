<?php
class AdminAddOrderController extends Controller
{
    public $response;
    public $data = array();
    public $repoOrder;
    public $repoUser;
    public $repoCustomer;
    public function __construct()
    {
        $this->response = new Response();
        if (!$this->auth()) {
            $this->response->redirect('admin-login/');
        }
        $this->repoOrder = new OrderRepository();
        $this->repoCustomer = new CustomerRepository();
        $this->repoUser = new UserRepository();
    }
    public function add()
    {
        $this->data['user'] = $_SESSION['user_login']['name'];
        $this->render('admins/order/addOrder', $this->data);
    }
    public function validateInfo($request)
    {
        $request->rules([
            'username' => 'required|max:20',
            'phone'=>'required|regex:/^[0-9]*$/',
            'address'=>'required',
            
        ]);
        $request->message([
            'username.required' => 'Please enter username',
            'username.min' => 'Username up to 20 characters',
            'phone.required'=>'Please enter phone',
            'phone.regex'=>'Please enter valid phone!',
            'address.required'=>'Please enter address!',
        ]);
        $validate = $request->validate();
        return $validate;
    }
    public function store()
    {
        $request = new Request();
        if (!$this->validateInfo($request)) {
            Session::flash('errors', $request->errors());
            Session::flash('old', $request->getFields());
            $this->response->redirect('admin-order-addOrder');
        }
        $data = [
                'name' => $_POST['username'],
                'phone' => $_POST['phone'],
                'type' => 'user',
            ];
        $this->repoUser->insert($data);
        $id = $this->db->lastInsertID();
        $data = [
                'user_id' => $id,
                'address' => $_POST['address']
            ];
        $this->repoCustomer->insert($data);
        $code = 'AP-'.time();
        $data = [
                'user_id' => $id,
                'code' => $code,
                'status' => 'handle',
                'payment' => $_POST['payment'],
                'total_price' => 0
            ];
        $this->repoOrder->insert($data);
        $id_order = $this->db->lastInsertID();
        $this->response->redirect('admin-order-add-'.$id_order.'.html');
    }
}
