<?php
class UserModel extends Model
{
    protected $_table = 'tbl_users';
    
    public function tableFill()
    {
        return 'tbl_users';
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
