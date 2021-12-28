<?php
class CustomerModel extends Model
{
    protected $_table = 'tbl_customers';
    
    public function tableFill()
    {
        return 'tbl_customers';
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
