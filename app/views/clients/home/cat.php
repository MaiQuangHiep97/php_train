<?php $this->render('blocks/header', $this->data) ?>

		<!-- NAVIGATION -->
		<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav">
					<li><a href="/demo">Home</a></li>
						<?php foreach ($product_cats as $product_cat) {?>
							<li class="<?= ($product_cat['id']==$cat_id)?'active':'' ?>"><a href="category-<?= $product_cat['id'] ?>"><?= $product_cat['cat_name'] ?></a></li>
						<?php } ?>
					</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
		<!-- /NAVIGATION -->


		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">List Products</h3>
							<div class="section-nav">
								<ul class="section-tab-nav tab-nav">
									<?php foreach ($product_cats as $product_cat) {?>
										<li class="<?= ($product_cat['id']==$cat_id)?'active':'' ?>"><a href="category-<?= $product_cat['id'] ?>"><?= $product_cat['cat_name'] ?></a></li>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<!-- <div class="products-tabs">
								<div id="tab1" class="tab-pane active"> -->
									
										<!-- product -->
										<?php if (!empty($products)) {
    foreach ($products as $product) {?>
												<div class="col-md-3">
													<div class="product">
														<form action="/demo/cart/add" method="post">
															<input type="hidden" name="product_id" value="<?=$product['id']?>">
															<input type="hidden" name="product_name" value="<?= $product['product_name']?>">
															<input type="hidden" name="product_thumb" value="<?= $product['product_thumb']?>">
															<input type="hidden" name="product_price" value="<?= $product['product_price']?>">
															<input type="hidden" name="product_qty" value="1">
														<div class="product-img">
															<img src="<?=URL_ASSET.'products/'.$product['product_thumb'] ?>" alt="">
														</div>
														<div class="product-body">
															<h3 class="product-name"><a href="/demo/product/detail?id=<?= $product['id'] ?>"><?= $product['product_name'] ?></a></h3>
															<h4 class="product-price"><?= number_format($product['product_price']).'đ' ?></h4>
															<div class="product-rating">
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
															</div>
														</div>
														<div class="add-to-cart">
															<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
														</div>
														</form>
													</div>
												</div>
											<?php }
} else {?>
<div class="text-center" style="margin-top: 30px;">
                        <h4 class="">There are no items</h4>
                        <a href="/demo">Home page</a>
                        </div>
<?php } ?>
										<!-- /product -->
									<!-- </div>
								</div> -->
								<!-- /tab -->
							
						</div>
                        <div class="">
							<?php if (isset($pagination)) {?>
								<ul class="pagination">
                                        <?= $pagination ?>
                                        </ul>
                                
							<?php } ?>
								</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->




		<!-- NEWSLETTER -->
		<?php $this->render('blocks/footer') ?>	
