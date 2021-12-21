<?php $this->render('blocks/header', $this->data) ?>

		<!-- NAVIGATION -->
		<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav">
					<li class="active"><a href="/demo">Home</a></li>
						<?php foreach ($product_cats as $product_cat) {?>
							<li><a href="category-<?= $product_cat['id'] ?>"><?= $product_cat['cat_name'] ?></a></li>
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
										<li><a data-toggle="tab" href="category-<?= $product_cat['id'] ?>"><?= $product_cat['cat_name'] ?></a></li>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
									
										<!-- product -->
										<?php foreach ($products as $product) {?>
											<div class="col-md-3">
												<div class="product">
													<form action="/demo/cart/add" method="post">
															<input type="hidden" name="product_id" value="<?= $product['id']?>">
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
										<?php }?>
										
										<!-- /product -->
									<!-- </div>
								</div> -->
								<!-- /tab -->
							
						</div>
						<div class="">
							
                                    <ul class="pagination">
                                        <?= $pagination ?>
                                        </ul>
                                
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
