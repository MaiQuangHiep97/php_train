<?php

class ProductImageRepository extends BaseRepository implements ProductImageRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return 'ImagesModel';
    }
    public function getImages($id)
    {
        return $this->model->db->table('tbl_product_images')->where('product_id', '=', $id)->get();
    }
    public function deleteImages($id)
    {
        return $this->model->db->table('tbl_product_images')->where('product_id', '=', $id)->delete();
    }
}
