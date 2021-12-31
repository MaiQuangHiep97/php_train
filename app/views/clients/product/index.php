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
						<?php foreach ($product_cats as $product_cat) {?>
							<li><a href="<?=_WEB_ROOT?>/category-<?= $product_cat['id'] ?>"><?= $product_cat['cat_name'] ?></a></li>
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
		

    
    

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- Product main img -->
                <div class="col-md-5 col-md-push-2">
                    <div id="product-main-img">
                        <?php foreach ($images as $image) {?>
                            <div class="product-preview">
                            <img src="<?=URL_ASSET.'images/'.$image['image'] ?>" alt="">
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- /Product main img -->

                <!-- Product thumb imgs -->
                <div class="col-md-2  col-md-pull-5">
                    <div id="product-imgs">
                    <?php foreach ($images as $image) {?>
                            <div class="product-preview">
                            <img src="<?=URL_ASSET.'images/'.$image['image'] ?>" alt="">
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- /Product thumb imgs -->

                <!-- Product details -->
                <div class="col-md-5">
                    <div class="product-details">
                        <h2 class="product-name"><?=$product['product_name']?></h2>
                        <div>
                            <div class="product-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <a class="review-link" href="#">10 Review(s) | Add your review</a>
                        </div>
                        <div>
                            <h3 class="product-price"><?=number_format($product['product_price']).'đ'?></h3>
                            <span class="product-available">In Stock</span>
                        </div>
                        <p><?=$product['product_des']?></p>
                        <div class="add-to-cart">
                        <form action="<?=_WEB_ROOT?>/cart-add" method="post">
							<input type="hidden" name="product_id" value="<?= $product['id']?>">
							<input type="hidden" name="product_name" value="<?= $product['product_name']?>">
							<input type="hidden" name="product_thumb" value="<?= $product['product_thumb']?>">
							<input type="hidden" name="product_price" value="<?= $product['product_price']?>">
                            <div class="qty-label">
                                Qty
                                <div class="input-number">
                                    <input type="number" name="product_qty" value="1" class="input-qty">
                                    <span class="qty-up">+</span>
                                    <span class="qty-down">-</span>
                                </div>
                            </div>
                            <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
                        </form>
                    </div>
                    </div>
                </div>
                <!-- /Product details -->

                <!-- Product tab -->
                <div class="col-md-12">
                    <div id="product-tab">
                        <!-- product tab nav -->
                        <ul class="tab-nav">
                            <li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
                            <li><a data-toggle="tab" href="#tab2">Details</a></li>
                        </ul>
                        <!-- /product tab nav -->

                        <!-- product tab content -->
                        <div class="tab-content">
                            <!-- tab1  -->
                            <div id="tab1" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><?= $product['product_des'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- /tab1  -->

                            <!-- tab2  -->
                            <div id="tab2" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><?= $product['product_detail'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- /tab2  -->
                        </div>
                        <!-- /product tab content  -->
                    </div>
                </div>
                <!-- /product tab -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- Section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <div class="col-md-12">
                    <div class="section-title text-center">
                        <h3 class="title">Related Products</h3>
                    </div>
                </div>

                <?php foreach ($products as $product) {?>
											<div class="col-md-3">
											<div class="product">
											<div class="product-img">
												<img src="<?=URL_ASSET.'products/'.$product['product_thumb'] ?>" alt="">
											</div>
											<div class="product-body">
												<h3 class="product-name"><a href="<?=_WEB_ROOT?>/product-detail?id=<?= $product['id'] ?>"><?= $product['product_name'] ?></a></h3>
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
										</div>
										</div>
										<?php }?>
                
                <div class="clearfix visible-sm visible-xs"></div>

                

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /Section -->

    <!-- NEWSLETTER -->
    




		<!-- NEWSLETTER -->
		<?php $this->render('blocks/footer') ?>	
        <script>
            $('.input-number').each(function() {
        var $this = $(this),
            $input = $this.find('input[type="number"]'),
            up = $this.find('.qty-up'),
            down = $this.find('.qty-down');

        down.on('click', function() {
            var value = parseInt($input.val()) - 1;
            value = value < 1 ? 1 : value;
            $input.val(value);
            $input.change();
            updatePriceSlider($this, value)
        })

        up.on('click', function() {
            var value = parseInt($input.val()) + 1;
            $input.val(value);
            $input.change();
            updatePriceSlider($this, value)
        })
    });
        </script>