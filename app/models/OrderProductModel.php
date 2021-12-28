<?php
class OrderProductModel extends Model
{
    protected $_table = 'tbl_order_products';
    
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
