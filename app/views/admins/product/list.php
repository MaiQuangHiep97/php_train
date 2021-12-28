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
                        <a href="<?php echo _WEB_ROOT;?>/admin/product/add" class="btn btn-primary" style="float:right">Add Product</a>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?php echo _DIR_ROOT;?>/dashboardcontroller/">Dashboard</a></li>
                            <li class="breadcrumb-item active">List Product</li>
                        </ol>
                        <?php if (count($products)>0) {?>
                            <div class="card mb-4">
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
                                           <td><img class="" style="width:75px; height:75px;" src="<?=URL_ASSET.'products/'.$product['product_thumb'] ?>" alt=""></a></td>
                                           <td><?=$product['product_name']?></td>
                                           <td><?=$product['cat_name']?></td>
                                           <td><?=number_format($product['product_price']).'đ'?></td>
                                           <td>    
                                               <a href="edit?id=<?= $product['id_pr']?>">Edit</a>
                                               <span>/</span>
                                               <a href="delete?id=<?=$product['id_pr']?>"
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
                
