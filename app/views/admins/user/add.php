<?php $this->render('blocks/auths/header') ?>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Add</h3></div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['error'])) {?>
    <div class="alert alert-danger text-danger text-center"><?php echo $_SESSION['error']?></div>
    <?php unset($_SESSION['error']);
} ?>
                                            
                                        <form method="POST" id="add-form" action="<?php echo _WEB_ROOT;?>/admin/user/store">
                                            <label for="username">Name</label>
                                            <div class="form-floating mb-3">
                                            <input type = "text" id="username" class = "form-control"value="<?php echo !empty($old['username'])?$old['username']:false?>" name = "username" placeholder = "Name"/>
                                            <?php echo(!empty($errors)&& array_key_exists('username', $errors))?'<span style="color: red;">'.$errors['username'].'</span>':false?>
                                            </div>
                                            <label for="email">Email address</label>
                                            <div class="form-floating mb-3">
                                            <input type = "text" id="email" class = "form-control" value="<?php echo !empty($old['email'])?$old['email']:false?>" name = "email" placeholder = "Email"/>
                                            <?php echo(!empty($errors)&& array_key_exists('email', $errors))?'<span style="color: red;">'.$errors['email'].'</span>':false?>
                                            </div>
                                            <label for="phone">Phone</label>
                                            <div class="form-floating mb-3">
                                            <input type = "text" id="phone" class = "form-control" value="<?php echo !empty($old['phone'])?$old['phone']:false?>" name = "phone" placeholder = "Phone"/>
                                            <?php echo(!empty($errors)&& array_key_exists('phone', $errors))?'<span style="color: red;">'.$errors['phone'].'</span>':false?>
                                            </div>
                                            <label for="password">Password</label>
                                            <div class="form-floating mb-3">
                                            <input type = "password" class = "form-control" name = "password" placeholder = "Password" id = "password"/>
                                            <?php echo(!empty($errors)&& array_key_exists('password', $errors))?'<span style="color: red;">'.$errors['password'].'</span>':false?>
                                            </div>
                                            <label>Roles</label><br>
                                            <div class="form-check">
                                            <input class="form-check-input" type="radio" checked name="type" id="user" value="user">
                                            <label class="form-check-label" for="user">User</label>
                                            </div>
                                            <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type" id="admin" value="admin">
                                            <label class="form-check-label" for="admin">Admin</label>
                                            </div>
                                            <?php echo(!empty($errors)&& array_key_exists('type', $errors))?'<span style="color: red;">'.$errors['type'].'</span>':false?>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type = "submit" class = "form-control btn btn-primary">Add User</button>
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