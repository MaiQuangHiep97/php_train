<?php

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return 'OrderModel';
    }
    public function getOrder()
    {
        return $this->model->db->table('tbl_orders')->join('tbl_users', 'tbl_users.id=tbl_orders.user_id')
        ->join('tbl_customers', 'tbl_customers.user_id=tbl_users.id')
        ->select('tbl_orders.id as id_order,tbl_customers.address as address_customer,tbl_orders.address as address_order, tbl_users.id as id_user, status, total_price, name, phone, code')->get();
    }
    public function pagiGetOrder($limit, $start)
    {
        return $this->model->db->table('tbl_orders')->join('tbl_users', 'tbl_users.id=tbl_orders.user_id')
        ->join('tbl_customers', 'tbl_customers.user_id=tbl_users.id')
        ->select('tbl_orders.id as id_order,tbl_customers.address as address_customer,tbl_orders.address as address_order, tbl_users.id as id_user, status, total_price, name, phone, code')
        ->limit($limit, $start)->get();
    }
    public function countCancel()
    {
        $data=$this->model->db->table('tbl_orders')->where('status', '=', 'cancel')->get();
        return count($data);
    }
    public function countHandle()
    {
        $data=$this->model->db->table('tbl_orders')->where('status', '=', 'handle')->get();
        return count($data);
    }
    public function countTransport()
    {
        $data=$this->model->db->table('tbl_orders')->where('status', '=', 'transport')->get();
        return count($data);
    }
    public function countDone()
    {
        $data=$this->model->db->table('tbl_orders')->where('status', '=', 'done')->get();
        return count($data);
    }
    public function getTotal()
    {
        $data = $this->model->db->table('tbl_orders')->where('status', '=', 'done')->select('total_price')->get();
        return $data;
    }
    public function getSearch($key)
    {
        return $this->model->db->table('tbl_orders')->join('tbl_users', 'tbl_users.id=tbl_orders.user_id')
        ->join('tbl_customers', 'tbl_customers.user_id=tbl_users.id')
        ->select('tbl_orders.id as id_order,tbl_customers.address as address_customer,tbl_orders.address as address_order, tbl_users.id as id_user, status, total_price, name, phone, code')
        ->where('code', 'LIKE', '%'.$key.'%')->orWhere('phone', 'LIKE', '%'.$key.'%')
        ->orWhere('name', 'LIKE', '%'.$key.'%')->get();
    }
    public function getSearchPagi($limit, $start, $key)
    {
        return $this->model->db->table('tbl_orders')->join('tbl_users', 'tbl_users.id=tbl_orders.user_id')
        ->join('tbl_customers', 'tbl_customers.user_id=tbl_users.id')
        ->select('tbl_orders.id as id_order,tbl_customers.address as address_customer,tbl_orders.address as address_order, tbl_users.id as id_user, status, total_price, name, phone, code')
        ->where('code', 'LIKE', '%'.$key.'%')->orWhere('phone', 'LIKE', '%'.$key.'%')
        ->orWhere('name', 'LIKE', '%'.$key.'%')->limit($limit, $start)->get();
    }
    public function getStatus($status)
    {
        return $this->model->db->table('tbl_orders')->join('tbl_users', 'tbl_users.id=tbl_orders.user_id')
        ->join('tbl_customers', 'tbl_customers.user_id=tbl_users.id')
        ->select('tbl_orders.id as id_order,tbl_customers.address as address_customer,tbl_orders.address as address_order, tbl_users.id as id_user, status, total_price, name, phone, code')
        ->where('status', '=', $status)->get();
    }
    public function getStatusPagi($limit, $start, $status)
    {
        return $this->model->db->table('tbl_orders')->join('tbl_users', 'tbl_users.id=tbl_orders.user_id')
        ->join('tbl_customers', 'tbl_customers.user_id=tbl_users.id')
        ->select('tbl_orders.id as id_order,tbl_customers.address as address_customer,tbl_orders.address as address_order, tbl_users.id as id_user, status, total_price, name, phone, code')
        ->where('status', '=', $status)->limit($limit, $start)->get();
    }
}
