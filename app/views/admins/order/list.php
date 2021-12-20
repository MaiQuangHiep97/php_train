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
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">List Order</li>
                        </ol>
                        <?php if (count($orders)>0) {?>
                            <div class="card mb-4">
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
                                                <a href="detail?id=<?=$value['id_order'] ?>">Detail</a>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div>
                                    <ul class="pagination" id="pagi-orders">
                                        <?= $pagination ?>
                                        </ul>
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
                
