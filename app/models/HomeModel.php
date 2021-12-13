<?php
class HomeModel extends Model
{
    protected $_table = 'tbl_users';
    public function getList()
    {
        $data = $this->db->table('tbl_users')->where('id', '=', 1)->get();
        // $data = $this->get();
        return $data;
    }
    public function tableFill()
    {
        return 'tbl_users';
    }
    public function fieldFill()
    {
        return 'name,email';
    }
    public function primaryKey()
    {
        return 'id';
    }
}
