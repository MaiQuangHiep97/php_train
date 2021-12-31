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
    public function updateQty($order_id, $product_id, $data)
    {
        return $this->model->db->table('tbl_order_products')->where('order_id', '=', $order_id)
        ->where('product_id', '=', $product_id)->update($data);
    }
    public function getWithOrder($id)
    {
        return $this->model->db->table('tbl_order_products')->where('order_id', '=', $id)->select('product_id')->get();
    }
    public function getQty($order_id, $product_id)
    {
        return $this->model->db->table('tbl_order_products')->where('order_id', '=', $order_id)
        ->where('product_id', '=', $product_id)->select('quantity')->first();
    }
}
