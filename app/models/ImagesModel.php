<?php
class ImagesModel extends Model
{
    protected $_table = 'tbl_product_images';
    
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
