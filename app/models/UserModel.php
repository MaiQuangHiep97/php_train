<?php
class UserModel extends Model
{
    protected $_table = 'products';
    public function getUser()
    {
        $data = $this->db->table('tbl_users')->where('email', '=', $_POST['email'])->where('type', '=', 'admin')->first();
        return $data;
    }
    public function updateUser($data)
    {
        if (!empty($data)) {
            $data = $this->db->table('tbl_users')->where('email', '=', $_SESSION['user_login']['email'])
            ->where('type', '=', 'admin')->update($data);
        }
    }
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
