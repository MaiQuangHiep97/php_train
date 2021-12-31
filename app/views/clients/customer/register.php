<?php $this->render('blocks/auths/header') ?>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Register Customer</h3></div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['error'])) {?>
    <div class="alert alert-danger text-danger text-center"><?php echo $_SESSION['error']?></div>
    <?php unset($_SESSION['error']);
} ?>
                                        <form method="POST" id="register-form" action="<?php echo _WEB_ROOT;?>/customer-postRegister">
                                        <label for="username">Name</label>
                                            <div class="form-floating mb-3">
                                            <input type = "text" id="username" class = "form-control" value="<?php echo !empty($old['username'])?$old['username']:false?>" name = "username" placeholder = "Name"/>
                                            <?php echo(!empty($errors)&& array_key_exists('username', $errors))?'<span style="color: red;">'.$errors['username'].'</span>':false?>
                                            </div>
                                            <label for="email">Email address</label>
                                            <div class="form-floating mb-3">
                                            <input type = "text" id="email" class = "form-control" value="<?php echo !empty($old['email'])?$old['email']:false?>" name = "email" placeholder = "Email"/>
                                            <?php echo(!empty($errors)&& array_key_exists('email', $errors))?'<span style="color: red;">'.$errors['email'].'</span>':false?>
                                            </div>
                                            <label for="password">Password</label>
                                            <div class="form-floating mb-3">
                                            <input type = "password" class = "form-control" name = "password" placeholder = "Password" id = "password"/>
                                            <?php echo(!empty($errors)&& array_key_exists('password', $errors))?'<span style="color: red;">'.$errors['password'].'</span>':false?>
                                            </div>
                                            <label for="confirm-password">Confirm Password</label>
                                            <div class="form-floating mb-3">
                                            <input type = "password" class = "form-control" name = "passwordConfirm" placeholder = "Confirm Password" id = "confirm-password"/>
                                            <?php echo(!empty($errors)&& array_key_exists('passwordConfirm', $errors))?'<span style="color: red;">'.$errors['passwordConfirm'].'</span>':false?>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type = "submit" class = "form-control btn btn-primary">Register</button>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4">
                                            <p>Do you have account? <a href="<?=_WEB_ROOT?>/customer-login">Login</a></p>
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
