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
                <form action="<?= _WEB_ROOT;?>/post-checkout" method="post" id="checkout-form">
				<div class="row">

					<div class="col-md-7">
						<!-- Billing Details -->
						<div class="billing-details">
							<div class="section-title">
								<h3 class="title">Billing address</h3>
							</div>
							<div class="form-group">
								<input class="input form-control" disabled type="text" name="username" value="<?= $customer['name'] ?>" placeholder="Name">
							</div>
							<div class="form-group">
								<input class="input form-control" disabled type="email" name="email" value="<?= $customer['email'] ?>" placeholder="Email">
							</div>
							<div class="form-group">
								<input class="input form-control" type="text" name="address" value="<?= $customer_info['address'] ?>" placeholder="Address">
								<?php echo(!empty($errors)&& array_key_exists('address', $errors))?'<span style="color: red;">'.$errors['address'].'</span>':false?>
							</div>
							<div class="form-group">
								<input class="input form-control" type="text" name="phone" value="<?= $customer['phone'] ?>" placeholder="Telephone">
								<?php echo(!empty($errors)&& array_key_exists('phone', $errors))?'<span style="color: red;">'.$errors['phone'].'</span>':false?>
							</div>							
						</div>
						<!-- /Billing Details -->

						<!-- Shiping Details -->
						<div class="shiping-details">
							<div class="section-title">
								<h3 class="title">Shiping address</h3>
							</div>
							<div class="input-checkbox">
								<input type="checkbox" id="shiping-address">
								<label for="shiping-address">
									<span></span>
									Ship to a diffrent address?
								</label>
								<div class="caption">
									<div class="form-group">
										<input class="input form-control" type="text" name="address1" placeholder="Address">
									</div>
								</div>
							</div>
						</div>
						<!-- /Shiping Details -->
					</div>

					<!-- Order Details -->
					<div class="col-md-5 order-details">
						<div class="section-title text-center">
							<h3 class="title">Your Order</h3>
						</div>
						<div class="order-summary">
							<div class="order-col">
								<div><strong>PRODUCT</strong></div>
								<div><strong>TOTAL</strong></div>
							</div>
							<div class="order-products">
                                <?php foreach ($cart['buy'] as $item) {?>
                                    <div class="order-col">
									<div><?= $item['qty'] ?>x   <?= $item['product_name'] ?></div>
									<div><?= number_format($item['sub_total']).'đ' ?></div>
								</div>
                                <?php } ?>
							</div>
							<div class="order-col">
								<div><strong>TOTAL</strong></div>
								<div><strong class="order-total"><?= number_format($cart['info']['total']) ?></strong></div>
							</div>
						</div>
						<div class="payment-method">
							<div class="input-radio">
								<input type="radio" checked name="payment" value="COD" id="payment-1">
								<label for="payment-1">
									<span></span>
									COD
								</label>
							</div>
						</div>
						<button type="submit" class="btn btn-danger form-control">Place order</button>
					</div>
					<!-- /Order Details -->
				</div>
                </form>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
<?php $this->render('blocks/footer', $this->data) ?>