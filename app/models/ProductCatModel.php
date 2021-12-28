<?php
class productCatModel extends Model
{
    protected $_table = 'tbl_product_cats';
    
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
