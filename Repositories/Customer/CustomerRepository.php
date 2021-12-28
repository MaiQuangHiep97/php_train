<?php

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return 'CustomerModel';
    }
    public function deleteWithUser($id)
    {
        return $this->model->db->table('tbl_customers')->where('user_id', '=', $id)->delete();
    }
    public function getCustomer($id)
    {
        return $this->model->db->table('tbl_customers')
            ->join('tbl_users', 'tbl_users.id=tbl_customers.user_id')->select('tbl_users.id as id_user, tbl_customers.id as id_customer, phone, address, email, name, gender')
            ->where('user_id', '=', $id)->get();
    }
    public function updateWithUserId($id, $data)
    {
        return $this->model->db->table('tbl_customers')->where('user_id', '=', $id)->update($data);
    }
}
