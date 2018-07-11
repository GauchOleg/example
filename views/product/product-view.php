<?php
/* @var $category \app\modules\dashboard\models\Category */
/* @var $product \app\modules\dashboard\models\Product */
?>
<div class="wrapper">
    <div id="cart-product">
        <div class="container" id="catalog">
            <?php echo $this->render('product',[
                'category'  => $category,
                'product'   => $product,
            ]);?>
        </div>
    </div>
</div>