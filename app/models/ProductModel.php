<?php
class ProductModel extends Model
{
    protected $_table = 'tbl_products';
    
    public function getProductImages($id)
    {
        $data = $this->db->table('tbl_product_images')->where('product_id', '=', $id)->get();
        return $data;
    }
    public function getProduct($id)
    {
        $data = $this->db->table('tbl_products')->where('id', '=', $id)->first();
        return $data;
    }
    public function getProducts()
    {
        $data = $this->db->table('tbl_products')->get();
        return $data;
    }
    
    public function getPagi($limit, $start)
    {
        $data = $this->db->table('tbl_products')->limit($limit, $start)->get();
        return $data;
    }
    public function deleteProduct($id)
    {
        $this->db->table('tbl_products')->where('id', '=', $id)->delete();
    }
    public function getAll()
    {
        $data = $this->db->table('tbl_products')
        ->join('tbl_product_cats', 'tbl_product_cats.id=tbl_products.cat_id')
        ->select('tbl_products.id as id_pr, tbl_product_cats.id as id_cat, product_name, product_detail, product_thumb, product_price, cat_name')->get();
        return $data;
    }
    public function getSearch($key)
    {
        $data = $this->db->table('tbl_products')
            ->join('tbl_product_cats', 'tbl_product_cats.id=tbl_products.cat_id')
            ->select('tbl_products.id as id_pr, tbl_product_cats.id as id_cat, product_name, product_detail, product_thumb, product_price, cat_name')
            ->where('cat_name', 'LIKE', '%'.$key.'%')->orWhere('product_name', 'LIKE', '%'.$key.'%')->get();
        return $data;
    }
    public function insertProduct($data)
    {
        if (!empty($data)) {
            $data = $this->db->table('tbl_products')->insert($data);
        }
    }
    
    public function tableFill()
    {
        return 'tbl_products';
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
