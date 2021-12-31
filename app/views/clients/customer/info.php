<?php $this->render('blocks/auths/header') ?>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Update Customer</h3></div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['error'])) {?>
    <div class="alert alert-danger text-danger text-center"><?php echo $_SESSION['error']?></div>
    <?php unset($_SESSION['error']);
} ?>
                                        <form method="POST" id="info-form" action="<?php echo _WEB_ROOT;?>/customer-postInfo">
                                            <input type="hidden" name="id" value="<?=$customer[0]['id_user']?>">
                                            <label for="username">Name</label>
                                            <div class="form-floating mb-3">
                                            <input type = "text" id="username" disabled class = "form-control" value="<?php echo (!empty($customer[0]['name']))?$customer[0]['name']:false?>" name = "username" placeholder = "Name"/>
                                            <?php echo(!empty($errors)&& array_key_exists('username', $errors))?'<span style="color: red;">'.$errors['username'].'</span>':false?>
                                            </div>
                                            <label for="email">Email address</label>
                                            <div class="form-floating mb-3">
                                            <input type = "text" id="email" disabled class = "form-control" value="<?php echo (!empty($customer[0]['email']))?$customer[0]['email']:false?>" name = "email" placeholder = "Email"/>
                                            <?php echo(!empty($errors)&& array_key_exists('email', $errors))?'<span style="color: red;">'.$errors['email'].'</span>':false?>
                                            </div>
                                            <label for="phone">Phone</label>
                                            <div class="form-floating mb-3">
                                            <input type = "text" id="phone" class = "form-control" value="<?php echo (!empty($customer[0]['phone']))?$customer[0]['phone']:false?>" name = "phone" placeholder = "Phone"/>
                                            <?php echo(!empty($errors)&& array_key_exists('phone', $errors))?'<span style="color: red;">'.$errors['phone'].'</span>':false?>
                                            </div>
                                            <label for="address">Address</label>
                                            <div class="form-floating mb-3">
                                            <input type = "text" id="address" class = "form-control" value="<?php echo !empty($customer[0]['address'])?$customer[0]['address']:false?>" name = "address" placeholder = "Address"/>
                                            <?php echo(!empty($errors)&& array_key_exists('address', $errors))?'<span style="color: red;">'.$errors['address'].'</span>':false?>
                                            </div>
                                            <label>Gender</label><br>
                                            <div class="form-check">
                                            <input class="form-check-input" type="radio"<?= ($customer[0]['gender']=='female')?'checked':''?> name="gender" id="female" value="female">
                                            <label class="form-check-label" for="female">Female</label>
                                            </div>
                                            <div class="form-check">
                                            <input class="form-check-input" <?= (!isset($customer[0]['gender']))?'checked':''?> type="radio"<?= ($customer[0]['gender']=='male')?'checked':''?>  name="gender" id="male" value="male">
                                            <label class="form-check-label" for="male">Male</label>
                                            </div>
                                            <?php echo(!empty($errors)&& array_key_exists('gender', $errors))?'<span style="color: red;">'.$errors['gender'].'</span>':false?>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type = "submit" class = "form-control btn btn-primary">Update Info</button>
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