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

                    <div class="col-md-12">
						<div class="row">
                        <div class="add-category col-md-6">
                            
                        <h1 class="mt-4" id="title">Add Category</h1>
                            <form method="POST" id="add-cat-form" action="<?php echo _WEB_ROOT;?>/admin-cat-store">
                                            <div class="mt-3">
                                            <input type = "text" id="category" class = "form-control" name = "category" placeholder = "Category"/>
                                            <?php echo(!empty($errors)&& array_key_exists('category', $errors))?'<span style="color: red;">'.$errors['category'].'</span>':false?>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type = "submit" class = "form-control btn btn-primary">Add Category</button>
                                            </div>
                                        </form>
                                        <form method="POST" id="edit-cat-form" action="<?php echo _WEB_ROOT;?>/admin-cat-update" class="d-none">
                                            <div class="mt-3">
                                                <input type="hidden" id="cate-id" name="cat_id" value="">
                                            <input type = "text" id="cate-edit" value="" class = "form-control" name = "category" placeholder = "Category"/>
                                            <?php echo(!empty($errors)&& array_key_exists('category', $errors))?'<span style="color: red;">'.$errors['category'].'</span>':false?>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type = "submit" class = "form-control btn btn-primary">Update Category</button>
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
                                                <a href="#" data-id = <?= $value['id']?> class="edit-cate btn btn-sm btn-primary">Edit</a>
                                                <a href="admin-cat-delete?id=<?= $value['id']?>" class=" btn btn-sm btn-danger">Delete</a>                    
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
<script type="text/javascript">
    $(document).ready(function(){
    $('.edit-cate').click(function(){
        $('#add-cat-form').addClass('d-none');
        $('#edit-cat-form').removeClass('d-none');
        var id = $(this).attr('data-id');
        $.ajax({
            url:'<?=URL?>/admin-cat-edit',
            method:'POST',
            data: {id:id},
            dataType:'json',
            success: function(data){
                $('#cate-edit').val(data.cat_name);
                $('#cate-id').val(data.id);
                $('h1#title').text('Edit Category');
            }
        });
    });
});
</script>
