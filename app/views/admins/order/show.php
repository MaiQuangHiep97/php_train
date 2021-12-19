<?php $this->render('blocks/admins/header', $this->data)?>
<?php $this->render('blocks/admins/sidebar')?>
<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                    <?php if (!empty($_SESSION['success'])) {?>
    <div class="alert alert-success text-success text-center"><?php echo $_SESSION['success']?></div>
    <?php unset($_SESSION['success']);
} ?>
                        <h1 class="mt-0">Show Order</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?php echo _DIR_ROOT;?>/dashboardcontroller/">Dashboard</a></li>
                            <li class="breadcrumb-item active">Show Order</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Show Order
                            </div>
                            <div class="card-body">
                            <h5>Customer Information</h5>

                                <div class = "list-group">
                                <a href = "#" class = "list-group-item">
                                    <h6 class = "list-group-item-heading">
                                    Code Order
                                    </h6>
                                    <p class = "list-group-item-text">
                                        <?= $order['code']?>
                                    </p>
                                </a>
                                <a href = "#" class = "list-group-item">
                                    <h6 class = "list-group-item-heading">
                                    Name
                                    </h6>
                                    <p class = "list-group-item-text">
                                    <?= $customer['name']?>
                                    </p>
                                </a>
                                <a href = "#" class="list-group-item">
                                    <h6 class = "list-group-item-heading">
                                        Phone
                                    </h6>
                                    <p class = "list-group-item-text">
                                    <?= $customer['phone']?>                                    
                                    </p>
                                </a>
                                <a href = "#" class = "list-group-item">
                                    <h6 class = "list-group-item-heading">Address</h6>
                                    <p class = "list-group-item-text"><?= $order['address']?></p>
                                </a>
                                <a href = "#" class = "list-group-item">
                                    <h6 class = "list-group-item-heading">Status</h6>
                                    <p class = "list-group-item-text"><?= $order['status']?></p>
                                </a>
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
                                    <tbody>
                                        <?php foreach ($order_products as $order_product) {?>
                                            <tr>
                                            <td><img class="" style="width:75px; height:75px;"
                                             src="<?=URL_ASSET.'products/'.$order_product['product_thumb'] ?>" alt=""></a></td>
                                            <td><?= $order_product['product_name'] ?></td>
                                            <td><?= $order_product['quantity'] ?></td>
                                            <td><?= number_format($order_product['product_price']).'đ' ?></td>
                                            <td>    
                                            <?= number_format($order_product['product_price']*$order_product['quantity']).'đ' ?>          
                                            </td>
                                        </tr>
                                        <?php } ?>
                                       
                                        
                                    </tbody>
                                </table>
                                <div>
                                    <h6>Total Price: <?= number_format($order['total_price']).'đ'?></h6> 
                                </div>
                            </div>
                        </div>
                    </div>
                </main>        
<?php $this->render('blocks/admins/footer')?>
                
