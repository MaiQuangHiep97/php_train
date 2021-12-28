<?php
class ProductModel extends Model
{
    protected $_table = 'tbl_products';
    
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
