<?php
class ImagesModel extends Model
{
    protected $_table = 'tbl_product_images';
    
    public function getImages($id)
    {
        $data = $this->db->table('tbl_product_images')->where('product_id', '=', $id)->get();
        return $data;
    }
    public function deleteImage($id)
    {
        $data = $this->db->table('tbl_product_images')->where('product_id', '=', $id)->delete();
    }
    
    
    public function tableFill()
    {
        return 'tbl_product_images';
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
