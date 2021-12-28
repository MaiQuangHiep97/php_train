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
        return $this->model->get();
    }
}
