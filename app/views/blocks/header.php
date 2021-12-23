<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Electro - HTML Ecommerce Template</title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT;?>/public/assets/clients/css/bootstrap.min.css"/>

		<!-- Slick -->
		<link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT;?>/public/assets/clients/css/slick.css"/>
		<link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT;?>/public/assets/clients/css/slick-theme.css"/>

		<!-- nouislider -->
		<link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT;?>/public/assets/clients/css/nouislider.min.css"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="<?php echo _WEB_ROOT;?>/public/assets/clients/css/font-awesome.min.css">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT;?>/public/assets/clients/css/style.css"/>


    </head>
	<body>
		<!-- HEADER -->
		<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">
						<li><a href="#"><i class="fa fa-phone"></i> +021-95-51-84</a></li>
						<li><a href="#"><i class="fa fa-envelope-o"></i> email@email.com</a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i> 1734 Stonecoal Road</a></li>
					</ul>
					<ul class="header-links pull-right">
                        <?php if (empty($customer)) {?>
                            <li><a href="/demo/customer/login"><i class="fa fa-user-o"></i> Login</a></li>
                       <?php } else {?>
                            <li><a href="/demo/customer/info"><i class="fa fa-user-o"></i> Hello, <?= $customer['name'] ?></a></li>
                            <li><a href="/demo/customer/logout"><i class="fa fa-dollar"></i> Logout</a></li>
                       <?php } ?>
					</ul>
				</div>
			</div>
			<!-- /TOP HEADER -->

			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="#" class="logo">
									<img src="./img/logo.png" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

						<!-- SEARCH BAR -->
						<div class="col-md-6">
							<div class="header-search">
								<form>
									<select class="input-select">
										<option value="0">All Categories</option>
										<option value="1">Category 01</option>
										<option value="1">Category 02</option>
									</select>
									<input class="input" placeholder="Search here">
									<button class="search-btn">Search</button>
								</form>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">
								<!-- Wishlist -->
								<div>
									<a href="#">
										<i class="fa fa-heart-o"></i>
										<span>Your Wishlist</span>
										<div class="qty">2</div>
									</a>
								</div>
								<!-- /Wishlist -->

								<!-- Cart -->
								<div class="dropdown">
									<a href="/demo/cart/show" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
										<i class="fa fa-shopping-cart"></i>
										<span>Your Cart</span>
										<div class="qty"id="qty"><?php
                                        if (isset($_SESSION['cart'])) {
                                            echo $_SESSION['cart']['info']['num_order'];
                                        } else {
                                            echo 0;
                                        }
                                        ?></div>
									</a>
									
								</div>
								<!-- /Cart -->

								<!-- Menu Toogle -->
								<div class="menu-toggle">
									<a href="#">
										<i class="fa fa-bars"></i>
										<span>Menu</span>
									</a>
								</div>
								<!-- /Menu Toogle -->
							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->
		</header>
		<!-- /HEADER -->