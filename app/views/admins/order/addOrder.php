<?php $this->render('blocks/admins/header', $this->data)?>
<?php $this->render('blocks/admins/sidebar')?>
<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                    <?php if (!empty($_SESSION['success'])) {?>
    <div class="alert alert-success text-success text-center"><?php echo $_SESSION['success']?></div>
    <?php unset($_SESSION['success']);
} ?>
<?php if (!empty($_SESSION['error'])) {?>
    <div class="alert alert-danger text-danger text-center"><?php echo $_SESSION['error']?></div>
    <?php unset($_SESSION['error']);
} ?>
                        <h1 class="mt-0">Add Order</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?php echo _DIR_ROOT;?>/dashboardcontroller/">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Order</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Add Order
                            </div>
                            <div class="card-body">
                            <h5>Customer Information</h5>

                                <div class = "list-group">
                                <form action="<?php echo _WEB_ROOT;?>/admin-order-storeOrder" id="add-order" method="POST">
                                <a class = "list-group-item">
                                    <h6 class = "list-group-item-heading">
                                    Name
                                    </h6>
                                    <input type="text" class="form-control" name="username" id="" value="">
                                    <?php echo(!empty($errors)&& array_key_exists('username', $errors))?'<span style="color: red;">'.$errors['username'].'</span>':false?>
                                </a>
                                <a class="list-group-item">
                                    <h6 class = "">
                                        Phone
                                    </h6>
                                    <input type="text" class="form-control" name="phone" id="" value="">
                                    <input type="hidden" name="id" value="">
                                    <input type="hidden" name="order_id" value="">
                                    <?php echo(!empty($errors)&& array_key_exists('phone', $errors))?'<span style="color: red;">'.$errors['phone'].'</span>':false?>
                                </a>
                                <a class = "list-group-item">
                                    <h6 class = "">Address</h6>
                                    <input type="text" class="form-control" name="address" id="" value="">
                                    <?php echo(!empty($errors)&& array_key_exists('address', $errors))?'<span style="color: red;">'.$errors['address'].'</span>':false?>
                                </a>
                                <a class = "list-group-item">
                                    <h6 class = "">Payment</h6>
                                    <div class="input-radio">
                                        <input type="radio" checked name="payment" value="COD" id="payment-1">
                                        <label for="payment-1">
									<span></span>
									COD
								</label>
							</div>
                                </a>
                                <input type="submit" style="float:right" class="form-control btn btn-primary mt-4" value="Add Info">
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>        
<?php $this->render('blocks/admins/footer')?>
         
