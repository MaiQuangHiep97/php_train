<?php

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return 'ProductModel';
    }
    public function getProduct()
    {
        return $this->model->db->table('tbl_products')
        ->join('tbl_product_cats', 'tbl_product_cats.id=tbl_products.cat_id')
        ->select('tbl_products.id as id_pr, tbl_product_cats.id as id_cat, product_name, product_detail, product_thumb, product_price, cat_name')->get();
    }
    public function getPagiCms($limit, $start)
    {
        return $this->model->db->table('tbl_products')
            ->join('tbl_product_cats', 'tbl_product_cats.id=tbl_products.cat_id')
            ->select('tbl_products.id as id_pr, tbl_product_cats.id as id_cat, product_name, product_detail, product_thumb, product_price, cat_name')
            ->limit($limit, $start)->get();
    }
    public function getPagi($limit, $start)
    {
        return $this->model->db->table('tbl_products')->limit($limit, $start)->get();
    }
    public function getWithCat($cat_id)
    {
        return $this->model->db->table('tbl_products')->where('cat_id', '=', $cat_id)->get();
    }
    public function getWithCatPagi($limit, $start, $cat_id)
    {
        return $this->model->db->table('tbl_products')->where('cat_id', '=', $cat_id)->limit($limit, $start)->get();
    }
    public function getSearch($key)
    {
        return $this->model->db->table('tbl_products')
            ->join('tbl_product_cats', 'tbl_product_cats.id=tbl_products.cat_id')
            ->select('tbl_products.id as id_pr, tbl_product_cats.id as id_cat, product_name, product_detail, product_thumb, product_price, cat_name')
            ->where('cat_name', 'LIKE', '%'.$key.'%')->orWhere('product_price', '=', $key)->orWhere('product_name', 'LIKE', '%'.$key.'%')->get();
    }
    public function getSearchPagi($limit, $start, $key)
    {
        return $this->model->db->table('tbl_products')
            ->join('tbl_product_cats', 'tbl_product_cats.id=tbl_products.cat_id')
            ->select('tbl_products.id as id_pr, tbl_product_cats.id as id_cat, product_name, product_detail, product_thumb, product_price, cat_name')
            ->where('cat_name', 'LIKE', '%'.$key.'%')->orWhere('product_price', '=', $key)->orWhere('product_name', 'LIKE', '%'.$key.'%')
            ->limit($limit, $start)->get();
    }
    public function getLimit()
    {
        return $this->model->db->table('tbl_products')->limit(4)->get();
    }
    public function getFill($from, $to)
    {
        return $this->model->db->table('tbl_products')->where('product_price', '>', $from)
        ->where('product_price', '<', $to)->join('tbl_product_cats', 'tbl_product_cats.id=tbl_products.cat_id')
        ->select('tbl_products.id as id_pr, tbl_product_cats.id as id_cat, product_name, product_detail, product_thumb, product_price, cat_name')->get();
    }
    public function getFillPagi($limit, $start, $from, $to)
    {
        return $this->model->db->table('tbl_products')->where('product_price', '>', $from)
        ->where('product_price', '<', $to)->join('tbl_product_cats', 'tbl_product_cats.id=tbl_products.cat_id')
        ->select('tbl_products.id as id_pr, tbl_product_cats.id as id_cat, product_name, product_detail, product_thumb, product_price, cat_name')->limit($limit, $start)->get();
    }
}
