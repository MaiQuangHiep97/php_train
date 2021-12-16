<?php
class productCatModel extends Model
{
    protected $_table = 'tbl_product_cats';
    
    public function getAll()
    {
        $data = $this->db->table('tbl_product_cats')->get();
        return $data;
    }
    
    public function tableFill()
    {
        return 'tbl_product_cats';
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
