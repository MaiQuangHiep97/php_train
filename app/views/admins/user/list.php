<?php $this->render('blocks/admins/header', $this->data)?>
<?php $this->render('blocks/admins/sidebar')?>
<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                    <?php if (!empty($_SESSION['success'])) {?>
    <div class="alert alert-success text-success text-center"><?php echo $_SESSION['success']?></div>
    <?php unset($_SESSION['success']);
} ?>

                        <h1 class="mt-4"><?= (($type == 'admin')?'List Admin':'List User') ?></h1>
                        <form action="<?php echo _WEB_ROOT;?>/admin-list-<?= $type ?>.html" method="GET" class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                            <div class="input-group">
                            <input class="form-control" value="<?= (isset($key))?$key:'' ?>" id="key-search" name="key" type="text" placeholder="Search for..." />
                            <button class="btn btn-primary" id="btnNavbarSearch" type="submit"><i class="fas fa-search key"></i></button>
                            </div>
                        </form>
                        <a href="<?php echo _WEB_ROOT;?>/admin-user-add" class="btn btn-primary" style="float:right">Add User</a>
                        <?php if (count($users)>0) {?>
                        <div class="card mb-4 mt-4" >
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
                                            <td>    
                                                <a href="<?php echo _WEB_ROOT; ?>/admin-user-edit-<?= $value['id']?>.html" class="btn btn-sm btn-primary">Edit</a>
                                                <?php if ($value['id'] !== $_SESSION['user_login']['id']) {?><a href="<?php echo _WEB_ROOT;?>/admin-user-delete?id=<?= $value['id']?>" class="btn btn-sm btn-danger">Delete</a>  
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

                
