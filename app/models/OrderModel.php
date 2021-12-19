<?php
class OrderModel extends Model
{
    protected $_table = 'tbl_orders';
    public function pagi_get($limit, $start)
    {
        $data = $this->db->table('tbl_orders')->join('tbl_users', 'tbl_users.id=tbl_orders.user_id')
        ->select('tbl_orders.id as id_order, tbl_users.id as id_user, status, total_price, address, name, phone, code')
        ->limit($limit, $start)->get();
        return $data;
    }
    public function getAll()
    {
        $data = $this->db->table('tbl_orders')->join('tbl_users', 'tbl_users.id=tbl_orders.user_id')
        ->select('tbl_orders.id as id_order, tbl_users.id as id_user, status, total_price, address, name, phone, code')->get();
        return $data;
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
