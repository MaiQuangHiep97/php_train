<?php

class ProductCatRepository extends BaseRepository implements ProductCatRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return 'ProductCatModel';
    }
    public function pagiGet($limit, $start)
    {
        return $this->model->db->table('tbl_product_cats')->limit($limit, $start)->get();
    }
    public function getCat($name)
    {
        return $this->model->db->table('tbl_product_cats')->where('cat_name', '=', $name)->first();
    }
}
