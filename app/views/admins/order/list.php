<?php $this->render('blocks/admins/header', $this->data)?>
<?php $this->render('blocks/admins/sidebar')?>
<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                    <?php if (!empty($_SESSION['success'])) {?>
    <div class="alert alert-success text-success text-center"><?php echo $_SESSION['success']?></div>
    <?php unset($_SESSION['success']);
} ?>
                        <h1 class="mt-4">List Order</h1>
                        <div class="row">
                            <div class="col-md-4">
                        <form action="<?php echo _WEB_ROOT;?>/admin-order-list" class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                            <div class="input-group">
                            <input class="form-control" value="<?= (isset($key))?$key:'' ?>" id="key-search" name="key" type="text" placeholder="Search for..." />
                            <button class="btn btn-primary" id="btnNavbarSearch" type="submit"><i class="fas fa-search key"></i></button>
                            </div>
                        </form>
                        </div>
                        <div class="col-md-4" style="display: flex;justify-content: center;">
                        <form action="<?php echo _WEB_ROOT;?>/admin-order-list">
                                <select class="form-control" style="width: 207px; float:left" name="status">
                                <option disabled selected>Status</option>
                                <option value="cancel" <?=((isset($status)) && ($status == 'cancel'))?'selected':''?>>Cancel</option>
                                <option value="handle" <?= ((isset($status)) && ($status == 'handle'))?'selected':'' ?>>Handle</option>
                                <option value="transport" <?= ((isset($status)) && ($status == 'transport'))?'selected':'' ?>>Transport</option>
                                <option value="done" <?= ((isset($status)) && ($status == 'done'))?'selected':'' ?>>Done</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Fill</button>
                                </form>
                                </div>
                                <div class="col-md-4">
                                <a href="<?php echo _WEB_ROOT;?>/admin-order-addOrder" class="btn btn-primary" style="float:right">Add Order</a>
                                </div>
                        </div>
                        <?php if (count($orders)>0) {?>
                            <div class="card mb-4 mt-3">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
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
                                            <td><?=(!empty($value['address_order'])?$value['address_order']:$value['address_customer'])?></td>
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
                                                <a href="admin-order-detail-<?=$value['id_order'] ?>.html">Detail</a>
                                                <?php if ($value['status'] == 'handle') { ?>
                                                    /<a href="admin-order-edit-<?=$value['id_order'] ?>.html">Edit</a>
                                               <?php } ?>
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
                
