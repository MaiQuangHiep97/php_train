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
                        <a href="<?php echo _WEB_ROOT;?>/admin-order-edit-<?= $order_id ?>.html" class="btn btn-success" style="width: 100px">Back</a>
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
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product) {?>
                                            <form action="<?= _WEB_ROOT;?>/admin-order-storeProduct" method="POST">
                                           <tr>
                                           <td><img style="width:75px; height:75px;" src="<?=URL_ASSET.'products/'.$product['product_thumb'] ?>" alt=""></a></td>
                                           <td><?=$product['product_name']?></td>
                                           <!-- <input type="hidden" value="<?=$order_id?>">
                                           <input type="hidden" value="<?=$product['id_pr']?>"> -->
                                           <td><?=$product['cat_name']?></td>
                                           <td><?=number_format($product['product_price']).'đ'?></td>
                                           <td><div class="input-number cart-qty">
                                                <input type="number" name="product_qty" min="1"
                                                 value="1" class="form-control qty-order-<?=$product['id_pr']?>" style="width:50px">
                                            </div></td>
                                           <td>    
                                               <input type="button" data-id="<?=$order_id?>" data-product-id="<?=$product['id_pr']?>" class="btn btn-danger add-to-order" value="Add to Order">            
                                           </td>
                                       </tr>
                                       </form>
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
<script type="text/javascript">  
$(document).ready(function(){
    $('.add-to-order').click(function(){
        var id = $(this).attr('data-id');
        var product_id = $(this).attr('data-product-id');
        var product_qty = $('.qty-order-'+product_id).val();
        var data = {product_id:product_id, product_qty:product_qty,
            id:id};
        $.ajax({
            url:'<?=URL?>/admin-order-storeProduct',
            method:'POST',
            data: data,
            dataType:'json',
            success: function(data){
                alert(data.data);
            }
        });
    });
});
</script>               
