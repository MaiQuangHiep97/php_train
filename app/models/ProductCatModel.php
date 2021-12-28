<?php
class productCatModel extends Model
{
    protected $_table = 'tbl_product_cats';
    
    public function getAll()
    {
        $data = $this->db->table('tbl_product_cats')->get();
        return $data;
    }
    public function pagiGet($limit, $start)
    {
        $data = $this->db->table('tbl_product_cats')->limit($limit, $start)->get();
        return $data;
    }
    public function insertCat($data)
    {
        $this->db->table('tbl_product_cats')->insert($data);
    }
    public function deleteCat($id)
    {
        $this->db->table('tbl_product_cats')->where('id', '=', $id)->delete();
    }
    public function updateCat($id, $data)
    {
        $this->db->table('tbl_product_cats')->where('id', '=', $id)->update($data);
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
