<?php $this->render('blocks/admins/header', $this->data)?>
<?php $this->render('blocks/admins/sidebar')?>
<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                    <?php if (!empty($_SESSION['success'])) {?>
    <div class="alert alert-success text-success text-center"><?php echo $_SESSION['success']?></div>
    <?php unset($_SESSION['success']);
} ?>
                        <h1 class="mt-4">List product</h1>
                        <div class="row">
                            <div class="col-md-4">
                        <form action="<?php echo _WEB_ROOT;?>/admin-product-list" class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                            <div class="input-group">
                            <input class="form-control" value="<?= (isset($key))?$key:'' ?>" id="key-search" name="key" type="text" placeholder="Search for..." />
                            <button class="btn btn-primary" id="btnNavbarSearch" type="submit"><i class="fas fa-search key"></i></button>
                            </div>
                        </form>
                        </div>
                        <div class="col-md-4" style="display: flex;justify-content: center;">
                        <form action="<?php echo _WEB_ROOT;?>/admin-product-list">
                                <select class="form-control" style="width: 207px; float:left" name="price">
                                <option disabled selected>Fillter by price</option>
                                <option value="0-100001"> < 100.000đ</option>
                                <option value="100001-300001">100.000đ - 300.000đ</option>
                                <option value="300001-600001">300.000đ - 600.000đ</option>
                                <option value="600001-10000000"> > 600.000đ</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Fill</button>
                                </form>
                                </div>
                                <div class="col-md-4">
                                <a href="<?php echo _WEB_ROOT;?>/admin-product-add" class="btn btn-primary" style="float:right">Add Product</a>
                                </div>
                        </div>
                        <?php if (count($products)>0) {?>
                            <div class="card mb-4 mt-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <div id="products">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product) {?>
                                           <tr>
                                           <td><img style="width:75px; height:75px;" src="<?=URL_ASSET.'products/'.$product['product_thumb'] ?>" alt=""></a></td>
                                           <td><?=$product['product_name']?></td>
                                           <td><?=$product['cat_name']?></td>
                                           <td><?=number_format($product['product_price']).'đ'?></td>
                                           <td>    
                                               <a href="<?=_WEB_ROOT?>/admin-product-edit-<?= $product['id_pr']?>.html" class="btn btn-sm btn-primary">Edit</a>
                                               <a href="<?=_WEB_ROOT?>/admin-product-delete-<?=$product['id_pr']?>.html" class="btn btn-sm btn-danger"
                                               >Delete</a>             
                                           </td>
                                       </tr>
                                       <?php } ?>
                                        
                                    </tbody>
                                </table>
                                <div>
                                <?php if (isset($pagination)) {?>
								<ul class="pagination">
                                        <?= $pagination ?>
                                        </ul>
                                
							<?php } ?>
                                </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        } else {?>
                            <div><h4>No product exist!</h4></div>
                            <?php
                        }
                        ?>
                        
                    </div>
                </main>        
<?php $this->render('blocks/admins/footer')?>       
