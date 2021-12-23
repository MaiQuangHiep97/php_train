<?php $this->render('blocks/admins/header', $this->data)?>
<?php $this->render('blocks/admins/sidebar')?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                    <?php if (!empty($_SESSION['success'])) {?>
    <div class="alert alert-success text-success text-center"><?php echo $_SESSION['success']?></div>
    <?php unset($_SESSION['success']);
} ?>
                        <h1 class="mt-4">Dashboard</h1>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="text-white">Done</div>
                                        <div class="text-white"><?= $done?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="text-white">Transport</div>
                                        <div class="text-white"><?= $transport?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="text-white">Handle</div>
                                        <div class="text-white"><?= $handle?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body d-flex align-items-center justify-content-between">
                                        <div class="text-white">Cancel</div>
                                        <div class="text-white"><?= $cancel?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "list-group-item mb-4">
                                    <h6 class = "list-group-item-heading">
                                    Total Revenue: <?= number_format($total_revenue).'đ' ?>
                                    </h6>
                        </div>
                        <?php if (count($orders)>0) {?>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Order Table
                            </div>
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Total Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($orders as $value) {
                                            ?>
                                            <tr>
                                            <td><?=$value['code']?></td>
                                            <td><?=$value['name']?></td>
                                            <td><?=$value['phone']?></td>
                                            <td><?=$value['address']?></td>
                                            <td class="<?php
                                            if ($value['status']=='handle') {
                                                echo 'text-success';
                                            } elseif ($value['status']=='done') {
                                                echo 'text-primary';
                                            } elseif ($value['status']=='transport') {
                                                echo 'text-warning';
                                            } else {
                                                echo 'text-danger';
                                            } ?>"><p class="text-capitalize"><?=$value['status']?></p></td>
                                            <td><?=number_format($value['total_price']).'đ'?></td>
                                            <td>
                                                <a href="admin/order/detail?id=<?=$value['id_order'] ?>">Detail</a>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
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
                        <?php
                        } else {?>
                            <div><h4>No order exist!</h4></div>
                            <?php
                        }
                        ?>
                        
                    </div>
                </main>
                <?php $this->render('blocks/admins/footer')?>
                
