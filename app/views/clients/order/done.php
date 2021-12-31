<?php $this->render('blocks/header', $this->data) ?>
<!-- NAVIGATION -->
<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav">
					<li class="active"><a href="<?=_WEB_ROOT?>">Home</a></li>
						<?php if (isset($product_cats)) {
    foreach ($product_cats as $product_cat) {?>
								<li><a href="category-<?= $product_cat['id'] ?>"><?= $product_cat['cat_name'] ?></a></li>
							<?php }
}?>
						 
					</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
		<!-- /NAVIGATION -->
        <div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
                <div class="text-center" style="margin-top: 30px;">
                        <h4>Thank you for your order</h4>
                        <a href="<?=_WEB_ROOT?>">Home page</a>
                        </div>
			</div>
			<!-- /container -->
		</div>
<?php $this->render('blocks/footer', $this->data) ?>