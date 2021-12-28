<?php

class OrderProductRepository extends BaseRepository implements OrderProductRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return 'OrderProductModel';
    }
    public function getDetail($id)
    {
        return $this->model->db->table('tbl_order_products')->join('tbl_products', 'tbl_products.id=tbl_order_products.product_id')
        ->select('tbl_order_products.id as id_order_product, tbl_products.id as id_products, order_id,product_thumb,quantity, product_name,product_price')->where('order_id', '=', $id)
        ->get();
    }
    // public function getOrder()
    // {
    //     return $this->model->db->table('tbl_orders')->join('tbl_users', 'tbl_users.id=tbl_orders.user_id')
    //     ->join('tbl_customers', 'tbl_customers.user_id=tbl_users.id')
    //     ->select('tbl_orders.id as id_order,tbl_customers.address as address_customer,tbl_orders.address as address_order, tbl_users.id as id_user, status, total_price, name, phone, code')->get();
    // }
    // public function pagiGetOrder($limit, $start)
    // {
    //     return $this->model->db->table('tbl_orders')->join('tbl_users', 'tbl_users.id=tbl_orders.user_id')
    //     ->join('tbl_customers', 'tbl_customers.user_id=tbl_users.id')
    //     ->select('tbl_orders.id as id_order,tbl_customers.address as address_customer,tbl_orders.address as address_order, tbl_users.id as id_user, status, total_price, name, phone, code')
    //     ->limit($limit, $start)->get();
    // }
}
