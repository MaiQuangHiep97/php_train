<?php

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return 'UserModel';
    }
    public function getList($type)
    {
        return $this->model->db->table('tbl_users')->where('type', '=', $type)->get();
    }
    public function getPagi($limit, $start, $type)
    {
        $data = $this->model->db->table('tbl_users')->where('type', '=', $type)->limit($limit, $start)->get();
        return $data;
    }
    public function getUser($email, $type)
    {
        return $this->model->db->table('tbl_users')->where('email', '=', $email)->where('type', '=', $type)->first();
    }
}
