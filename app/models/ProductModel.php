<?php
class ProductModel extends Model
{
    protected $_table = 'tbl_products';
    
    public function getProductImages($id)
    {
        $data = $this->db->table('tbl_product_images')->where('product_id', '=', $id)->get();
        return $data;
    }
    public function getProduct($id)
    {
        $data = $this->db->table('tbl_products')->where('id', '=', $id)->first();
        return $data;
    }
    public function deleteProduct($id)
    {
        $this->db->table('tbl_products')->where('id', '=', $id)->delete();
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
