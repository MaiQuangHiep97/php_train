<?php $this->render('blocks/admins/header', $this->data)?>
<?php $this->render('blocks/admins/sidebar')?>
<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                    <?php if (!empty($_SESSION['success'])) {?>
    <div class="alert alert-success text-success text-center"><?php echo $_SESSION['success']?></div>
    <?php unset($_SESSION['success']);
} ?>

                    <div class="col-md-12">
						<div class="row">
                        <div class="add-category col-md-6">
                        <h1 class="mt-4">Add Category</h1>
                            <form method="POST" id="add-cat-form" action="<?php echo _WEB_ROOT;?>/admin/cat/store">
                                            <div class="mt-3">
                                            <input type = "text" id="category" class = "form-control" name = "category" placeholder = "Category"/>
                                            <?php echo(!empty($errors)&& array_key_exists('category', $errors))?'<span style="color: red;">'.$errors['category'].'</span>':false?>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type = "submit" class = "form-control btn btn-primary">Add Category</button>
                                            </div>
                                        </form>
                            </div>
                        <div class="col-md-6">
                        <h1 class="mt-4">List Category</h1>
                        <?php if (count($cats)>0) {?>
                        <div class="card mb-4" >
                            <!-- list -->
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                     
                                    <tbody>
                                        <?php
                                        foreach ($cats as $value) {
                                            ?>
                                            <tr>
                                            <td><?=$value['cat_name']?></td>
                                            <td>    
                                                <a href="edit?id=<?= $value['id']?>">Edit</a>
                                                <span>/</span>
                                                <a href="delete?id=<?= $value['id']?>">Delete</a>                    
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
                        <div><h4>No cats exist!</h4></div>
                        <?php }?>
                        </div>
                </main>      
<?php $this->render('blocks/admins/footer')?>

