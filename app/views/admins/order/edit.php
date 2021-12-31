<?php $this->render('blocks/admins/header', $this->data)?>
<?php $this->render('blocks/admins/sidebar')?>
<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                    <?php if (!empty($_SESSION['success'])) {?>
    <div class="alert alert-success text-success text-center"><?php echo $_SESSION['success']?></div>
    <?php unset($_SESSION['success']);
} ?>
                        <h1 class="mt-0">Edit Order</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?php echo _DIR_ROOT;?>/dashboardcontroller/">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Order</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Edit Order
                            </div>
                            <div class="card-body">
                            <h5>Customer Information</h5>

                                <div class = "list-group">
                                <a class = "list-group-item">
                                    <h6 class = "">
                                    Code Order
                                    </h6>
                                    <p class = "list-group-item-text">
                                        <?= $order['code']?>
                                    </p>
                                </a>
                                <a class = "list-group-item">
                                    <h6 class = "list-group-item-heading">
                                    Name
                                    </h6>
                                    <p class = "">
                                    <?= $customer[0]['name']?>
                                    </p>
                                </a>
                                <form action="<?php echo _WEB_ROOT;?>/admin-order-updateInfo" method="POST">
                                <a class="list-group-item">
                                    <h6 class = "">
                                        Phone
                                    </h6>
                                    <input type="text" class="form-control" name="phone" id="" value="<?= $customer[0]['phone']?>">
                                    <input type="hidden" name="id" value="<?= $customer[0]['id_user'] ?>">
                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                    <?php echo(!empty($errors)&& array_key_exists('phone', $errors))?'<span style="color: red;">'.$errors['phone'].'</span>':false?>
                                </a>
                                <a class = "list-group-item">
                                    <h6 class = "">Address</h6>
                                    <input type="text" class="form-control" name="address" id="" value="<?=(!empty($order['address'])?$order['address']:$customer[0]['address'])?>">
                                    <?php echo(!empty($errors)&& array_key_exists('address', $errors))?'<span style="color: red;">'.$errors['address'].'</span>':false?>
                                </a>
                                <input type="submit" style="float:right" class="btn btn-primary mt-4" value="Update Info">
                                </form>
                                </div>
                                <h5 class="mt-3">Order Information</h5>
                                    <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Sub total</th>
                                        </tr>
                                    </thead>
                                    <?php if (count($order_products) > 0) { ?>
                                    <tbody>
                                        <?php foreach ($order_products as $order_product) {?>
                                            <tr class="item-<?= $order_product['id_products'] ?>">
                                            <td><img class="" style="width:75px; height:75px;"
                                             src="<?=URL_ASSET.'products/'.$order_product['product_thumb'] ?>" alt=""></a></td>
                                             <input type="hidden" class="id-order" value="<?= $order['id'] ?>">
                                            <td><?= $order_product['product_name'] ?></td>
                                            <td><div class="input-number cart-qty">
                                                <input type="number" name="product_qty" min="0" data-id="<?= $order_product['id_products']?>"
                                                 value="<?= $order_product['quantity'] ?>" data-price = "<?= $order_product['product_price'] ?>" class="form-control qty-order" style="width:50px">
                                            </div></td>
                                            <td><?= number_format($order_product['product_price']).'đ' ?></td>
                                            <td class="sub-total-<?= $order_product['id_products'] ?>">    
                                            <?= number_format($order_product['product_price']*$order_product['quantity']).'đ' ?>          
                                            </td>
                                        </tr>
                                        <?php } ?>                                       
                                    </tbody>
                                    <?php } ?> 
                                </table>
                                <div>
                                    <h6 id="total">Total Price: <?= number_format($order['total_price']).'đ'?></h6> 
                                </div>                             
                                <a href="<?=_WEB_ROOT?>/admin-order-add-<?= $order['id'] ?>.html" class="btn btn-danger" style="float:right">Add product</a>
                            </div>
                        </div>
                    </div>
                </main>        
<?php $this->render('blocks/admins/footer')?>
<script type="text/javascript">  
$(document).ready(function(){
    $('.qty-order').change(function(){
        var numOrder = $(this).val();
        var id = $(this).attr('data-id');
        var price = $(this).attr('data-price');
        var idOrder = $('.id-order').val();
        var data = {numOrder:numOrder,
            id:id, idOrder:idOrder, price:price};
        $.ajax({
            url:'<?=URL?>/admin-order-updateQty',
            method:'POST',
            data: data,
            dataType:'json',
            success: function(data){
                $('#total').text('Total Price: '+data.total);
                $('.sub-total-'+id).text(data.sub_total);
                if(data.numOrder == 0){
                    $('.item-'+id).remove();
                }
            }
        });
    });
});
</script>               
