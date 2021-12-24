<?php
class OrderModel extends Model
{
    protected $_table = 'tbl_orders';
    public function insertOrder($data)
    {
        $this->db->table('tbl_orders')->insert($data);
    }
    public function pagi_get($limit, $start)
    {
        $data = $this->db->table('tbl_orders')->join('tbl_users', 'tbl_users.id=tbl_orders.user_id')
        ->join('tbl_customers', 'tbl_customers.user_id=tbl_users.id')
        ->select('tbl_orders.id as id_order,tbl_customers.address as address_customer,tbl_orders.address as address_order, tbl_users.id as id_user, status, total_price, name, phone, code')
        ->limit($limit, $start)->get();
        return $data;
    }
    public function getAll()
    {
        $data = $this->db->table('tbl_orders')->join('tbl_users', 'tbl_users.id=tbl_orders.user_id')
        ->join('tbl_customers', 'tbl_customers.user_id=tbl_users.id')
        ->select('tbl_orders.id as id_order,tbl_customers.address as address_customer,tbl_orders.address as address_order, tbl_users.id as id_user, status, total_price, name, phone, code')->get();
        return $data;
    }
    public function updateStatus($id, $data)
    {
        $this->db->table('tbl_orders')->where('id', '=', $id)->update($data);
    }
    public function countCancel()
    {
        $data=$this->db->table('tbl_orders')->where('status', '=', 'cancel')->get();
        return count($data);
    }
    public function countHandle()
    {
        $data=$this->db->table('tbl_orders')->where('status', '=', 'handle')->get();
        return count($data);
    }
    public function countTransport()
    {
        $data=$this->db->table('tbl_orders')->where('status', '=', 'transport')->get();
        return count($data);
    }
    public function countDone()
    {
        $data=$this->db->table('tbl_orders')->where('status', '=', 'done')->get();
        return count($data);
    }
    public function tableFill()
    {
        return 'tbl_orders';
    }
    public function fieldFill()
    {
        return '*';
    }
    public function primaryKey()
    {
        return 'id';
    }
}
