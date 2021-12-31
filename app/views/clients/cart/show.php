<?php $this->render('blocks/header', $this->data) ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1" id="cart-none">
        <?php if (isset($cart)) {?>
            <table id="cart-table" class="table table-hover">
                <thead>
                    <tr>
                        <th>   </th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Sub Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                        <?php foreach ($cart['buy'] as $item) {
    if (isset($item)) {?>
                                <!-- <input type="checkbox" class="form-check-input"> -->
                                <tr class="item<?=$item['product_id']?>">
                                <td>
                                    <input type="checkbox" name="info_item" id="">
                                </td>
                            <td class="col-sm-8 col-md-6">
                            <div class="media">
                                <a class="thumbnail pull-left" href="#"> <img class="media-object" src="<?=URL_ASSET.'products/'.$item['product_thumb'] ?>" style="width: 72px; height: 72px;"> </a>
                                <div class="media-body">
                                    <h4 class="media-heading"><a href="#"><?= $item['product_name'] ?></a></h4>
                                    <span>Status: </span><span class="text-success"><strong>In Stock</strong></span>
                                </div>
                            </div></td>
                            <td class="col-sm-1 col-md-1" style="text-align: center">
                            <div class="input-number cart-qty">
                                <input type="number" name="product_qty" data-id="<?= $item['product_id']?>" value="<?= $item['qty'] ?>" min="1" max="20" class="input-qty cart-qty">
                                <span class="qty-up up">+</span>
                                <span class="qty-down down">-</span>
                            </div>
                            </td>
                            <td class="col-sm-1 col-md-1 text-center"><strong><?=number_format($item['product_price']).'đ'?></strong></td>
                            <td class="col-sm-1 col-md-1 text-center"><strong class="sub-total<?=$item['product_id']?>"><?=number_format($item['sub_total']).'đ'?></strong></td>
                            <td class="col-sm-1 col-md-1">
                            <button type="button" class="btn btn-danger remove-cart" data-id="<?= $item['product_id']?>">Remove
                            </button></td>
                        </tr>
                            
                                <?php } ?>
                            
                        <?php
} ?>
                    
                    <tr>
                    <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h3>Total</h3></td>
                        <td class="text-right"><h3><strong id="total"><?=number_format($cart['info']['total']).'đ'?></strong></h3></td>
                    </tr>
                    <tr>
                    <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><a href="<?=_WEB_ROOT?>/cart-destroy" class="btn btn-danger">Delete</a></td>
                        <td>
                            <a href="<?=_WEB_ROOT?>" class="btn btn-primary">Continue Shopping</a>
                        </td>
                        <td>
                            <a href="<?=_WEB_ROOT?>/checkout" class="btn btn-success">Checkout</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php } else {?>
                <div class="text-center" style="margin-top: 30px;">
                        <h4>There are no items in the cart </h4>
                        <a href="<?=_WEB_ROOT?>">Home page</a>
                        </div>
                    <?php } ?>
        </div>
    </div>
</div>
<?php $this->render('blocks/footer', $this->data) ?>
<script>
    $('.cart-qty').each(function() {
		var $this = $(this),
		$input = $this.find('.cart-qty'),
		cart_up = $this.find('.up'),
		cart_down = $this.find('.down');

		cart_down.on('click', function () {
			var value = parseInt($input.val()) - 1;
			value = value < 1 ? 0 : value;
			$input.val(value);
			$input.change();
		})

		cart_up.on('click', function () {
			var value = parseInt($input.val()) + 1;
			$input.val(value);
			$input.change();
		})
	});
</script>
<script type="text/javascript">  
$(document).ready(function(){
    $('.input-qty').change(function(){
        var numOrder = $(this).val();
        var id = $(this).attr('data-id');
        $.ajax({
            url:'<?=URL?>/cart-update',
            method:'POST',
            data: {numOrder:numOrder,
            id:id},
            dataType:'json',
            success: function(data){
                //console.log(data);
                $('#total').text(data.total);
                $('.sub-total'+id).text(data.sub_total);
                $('#qty').text(data.num_order);
                if(data.numOrder < 1){
                    $('.item'+id).remove();
                }
                if(data.num_order == 0){
                    $('#cart-table').remove();
                    $('#cart-none').append(data.display);
                }
            }
        });
    });
});
$(document).ready(function(){
    $('.remove-cart').click(function(){
        var id = $(this).attr('data-id');
        $.ajax({
            url:'<?=URL?>/cart-delete',
            method:'POST',
            data: {id:id},
            dataType:'json',
            success: function(data){
                $('#total').text(data.total);
                $('#qty').text(data.num_order);
                $('.item'+id).remove();
                if(data.num_order == 0){
                    $('#cart-table').remove();
                    $('#cart-none').append(data.display);
                }
            }
        });
    });
});
</script>