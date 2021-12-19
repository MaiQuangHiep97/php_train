<?php
class OrderProductModel extends Model
{
    protected $_table = 'tbl_order_products';
    public function getDetail($id)
    {
        $data = $this->db->table('tbl_order_products')->join('tbl_products', 'tbl_products.id=tbl_order_products.product_id')
        ->select('tbl_order_products.id as id_order_product, tbl_products.id as id_products, order_id,product_thumb,quantity, product_name,product_price')->where('order_id', '=', $id)
        ->get();
        return $data;
    }
    
    public function tableFill()
    {
        return 'tbl_order_products';
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
