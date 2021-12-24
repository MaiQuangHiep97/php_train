<?php $this->render('blocks/admins/header', $this->data)?>
<?php $this->render('blocks/admins/sidebar')?>
<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4 text-center" style="width: 50%">
                    <?php if (!empty($_SESSION['success'])) {?>
    <div class="alert alert-success text-success text-center"><?php echo $_SESSION['success']?></div>
    <?php unset($_SESSION['success']);
} ?>
                        <h1 class="mt-4">Update Category</h1>
                            <form method="POST" id="edit-cat-form" action="<?php echo _WEB_ROOT;?>/admin/cat/update">
                                            <div class="mt-3">
                                                <input type="hidden" name="cat_id" value="<?= $category['id'] ?>">
                                            <input type = "text" id="category" value="<?= $category['cat_name'] ?>" class = "form-control" name = "category" placeholder = "Category"/>
                                            <?php echo(!empty($errors)&& array_key_exists('category', $errors))?'<span style="color: red;">'.$errors['category'].'</span>':false?>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type = "submit" class = "form-control btn btn-primary">Update Category</button>
                                            </div>
                                        </form>
                            </div>
                </main>      
<?php $this->render('blocks/admins/footer')?>

                
