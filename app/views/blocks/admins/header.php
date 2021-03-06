<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - SB Admin</title>
        <link href="<?php echo _WEB_ROOT;?>/public/assets/admin/dist/css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo _WEB_ROOT;?>/public/assets/admin/ckeditor/ckeditor.js"></script>
    <script src="<?php echo _WEB_ROOT;?>/public/assets/admin/ckefinder/ckfinder.js"></script>
    <!-- <script>    
    if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
    }
</script> -->
    </head>
    <body class="sb-nav-fixed">
    <style>
  	.error{
    	color: red;
        font-style: italic;
    }
    </style>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            
            <a class="navbar-brand ps-3" href="">Menu</a>
            
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <!-- <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div> -->
            </form>
            
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">Hello, <?php echo $user ?> <i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><form method="GET" action="<?php echo _WEB_ROOT;?>/admin-getChange">
                        <button class="btn dropdown-item">Change password</button>
                        </form>
                        </li>
                        <li><form method="POST" action="<?php echo _WEB_ROOT;?>/admin-logout">
                        <button class="btn dropdown-item">Logout</button>
                        </form></li>
                    </ul>
                </li>
            </ul>
        </nav>