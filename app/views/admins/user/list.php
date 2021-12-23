<?php $this->render('blocks/admins/header', $this->data)?>
<?php $this->render('blocks/admins/sidebar')?>
<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                    <?php if (!empty($_SESSION['success'])) {?>
    <div class="alert alert-success text-success text-center"><?php echo $_SESSION['success']?></div>
    <?php unset($_SESSION['success']);
} ?>

                        <h1 class="mt-4">List user</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="<?php echo _DIR_ROOT;?>/dashboardcontroller/">Dashboard</a></li>
                            <li class="breadcrumb-item active">List User</li>
                        </ol>
                        <?php if (count($users)>0) {?>
                        <div class="card mb-4" >
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                     
                                    <tbody>
                                        <?php
                                        foreach ($users as $value) {
                                            ?>
                                            <tr>
                                            <td><?=$value['name']?></td>
                                            <td><?=$value['email']?></td>
                                            <td><?=$value['phone']?></td>
                                            <td><?=$value['type']?></td>
                                            <td>    
                                                <a href="edit?id=<?= $value['id']?>">Edit</a>
                                                <span>/</span>
                                                <?php if ($value['id'] !== $_SESSION['user_login']['id']) {?><a href="delete?id=<?= $value['id']?>">Delete</a>  
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
                    
                    <?php } else {?>
                        <div><h4>No users exist!</h4></div>
                        <?php }?>
                        </div>
                </main>      
<?php $this->render('blocks/admins/footer')?>

                
