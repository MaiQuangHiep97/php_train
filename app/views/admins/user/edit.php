<?php $this->render('blocks/auths/header') ?>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Update</h3></div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['error'])) {?>
    <div class="alert alert-danger text-danger text-center"><?php echo $_SESSION['error']?></div>
    <?php unset($_SESSION['error']);
} ?>
                                            
                                        <form method="POST" id="edit-form" action="<?php echo _WEB_ROOT;?>/admin/user/update">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <label for="username">Name</label>
                                            <div class="form-floating mb-3">
                                            <input type = "text" id="username" class = "form-control" value="<?= $user['name']?>" name = "username" placeholder = "Name"/>
                                            <?php echo(!empty($errors)&& array_key_exists('username', $errors))?'<span style="color: red;">'.$errors['username'].'</span>':false?>
                                            </div>
                                            <label for="email">Email address</label>
                                            <div class="form-floating mb-3">
                                            <input type = "text" id="email" value="<?= $user['email']?>" class = "form-control" name = "email" placeholder = "Email"/>
                                            </div>
                                            <label for="phone">Phone</label>
                                            <div class="form-floating mb-3">
                                            <input type = "text" id="phone" class = "form-control" value="<?= $user['phone']?>" name = "phone" placeholder = "Phone"/>
                                            <?php echo(!empty($errors)&& array_key_exists('phone', $errors))?'<span style="color: red;">'.$errors['phone'].'</span>':false?>
                                            </div>
                                            <label for="password">Password</label>
                                            <div class="form-floating mb-3">
                                            <input type = "password" class = "form-control" name = "password" placeholder = "Password" id = "password"/>
                                            <?php echo(!empty($errors)&& array_key_exists('password', $errors))?'<span style="color: red;">'.$errors['password'].'</span>':false?>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type = "submit" class = "form-control btn btn-primary">Update User</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            
        </div>
        <?php $this->render('blocks/auths/footer') ?>
