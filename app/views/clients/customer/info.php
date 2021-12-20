<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Infor-Customer</title>
        <link href="<?php echo _WEB_ROOT;?>/public/assets/admin/dist/css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-dark">
    <style>
  	.error{
    	color: red;
        font-style: italic;
        padding-top: 30px;
    }
  </style>
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
                                        <form method="POST" id="info-form" action="<?php echo _WEB_ROOT;?>/customer/postInfo">
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
                                            <input class="form-check-input" type="radio"<?= (!empty($customer[0]['gender'])&&$customer[0]['gender']=='female')?'checked':''?> name="gender" id="female" value="female">
                                            <label class="form-check-label" for="female">Female</label>
                                            </div>
                                            <div class="form-check">
                                            <input class="form-check-input" type="radio"<?= (!empty($customer[0]['gender'])&&$customer[0]['gender']=='male')?'checked':''?>  name="gender" id="male" value="male">
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
        <script src="http://code.jquery.com/jquery-3.4.1.min.js" 
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="<?php echo _WEB_ROOT;?>/public/assets/admin/dist/js/scripts.js"></script> 
    </body>
</html>
