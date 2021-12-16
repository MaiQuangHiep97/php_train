<?php
class ProductModel extends Model
{
    protected $_table = 'tbl_products';
    
    public function getProductImages($id)
    {
        $data = $this->db->table('tbl_product_images')->where('product_id', '=', $id)
        ->join('tbl_products', 'tbl_product_images.product_id=tbl_products.id')->select('image')->get();
        return $data;
    }
    public function getProduct($id)
    {
        $data = $this->db->table('tbl_products')->where('id', '=', $id)->first();
        return $data;
    }
    
    public function insertProduct($data)
    {
        if (!empty($data)) {
            $data = $this->db->table('tbl_products')->insert($data);
        }
    }
    
    public function tableFill()
    {
        return 'tbl_products';
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
