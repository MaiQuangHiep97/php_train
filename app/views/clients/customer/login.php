<?php $this->render('blocks/auths/header') ?>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login Customer</h3></div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['error'])) {?>
    <div class="alert alert-danger text-danger text-center"><?php echo $_SESSION['error']?></div>
    <?php unset($_SESSION['error']);
} ?>
<?php if (!empty($_SESSION['success'])) {?>
    <div class="alert alert-success text-success text-center"><?php echo $_SESSION['success']?></div>
    <?php unset($_SESSION['success']);
} ?>
                                        <form method="POST" id="login-form" action="<?php echo _WEB_ROOT;?>/customer-postLogin">
                                        <input type="hidden" name="type" value="user">
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
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" name="remember" value="remember" />
                                                <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type = "submit" class = "form-control btn btn-primary">Login</button>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <p>Do not have an account? <a href="<?=_WEB_ROOT?>/customer-register">Register</a></p>
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
        <?php $this->render('blocks/auths/footer')?>
