<?php $this->render('blocks/header', $this->data) ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Sub Total</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart['buy'] as $item) {?>
                        <tr>
                        <td class="col-sm-8 col-md-6">
                        <div class="media">
                            <a class="thumbnail pull-left" href="#"> <img class="media-object" src="<?=URL_ASSET.'products/'.$item['product_thumb'] ?>" style="width: 72px; height: 72px;"> </a>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="#"><?= $item['product_name'] ?></a></h4>
                                <span>Status: </span><span class="text-success"><strong>In Stock</strong></span>
                            </div>
                        </div></td>
                        <td class="col-sm-1 col-md-1" style="text-align: center">
                        <input type="email" class="form-control" id="exampleInputEmail1" value="<?= $item['qty'] ?>">
                        </td>
                        <td class="col-sm-1 col-md-1 text-center"><strong><?=number_format($item['product_price']).'đ'?></strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong><?=number_format($item['sub_total']).'đ'?></strong></td>
                        <td class="col-sm-1 col-md-1">
                        <button type="button" class="btn btn-danger">Remove
                        </button></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h3>Total</h3></td>
                        <td class="text-right"><h3><strong><?=number_format($cart['info']['total']).'đ'?></strong></h3></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>
                            <a href="/demos" class="btn btn-primary">Continue Shopping</a>
                        </td>
                        <td>
                            <a href="" class="btn btn-success">Checkout</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $this->render('blocks/footer', $this->data) ?>